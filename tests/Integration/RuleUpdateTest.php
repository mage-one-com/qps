<?php

namespace MageOne\Qps\Test\Integration;

use Exception;
use Mage;
use Mage_Core_Model_Resource;
use Mage_HTTP_IClient;
use MageOne\Qps\Test\AbstractTest;
use Mageone_Qps_Helper_Data;
use Mageone_Qps_Model_Cron;
use Mageone_Qps_Model_Observer;
use Mageone_Qps_Model_Rule;
use Mageone_Qps_Model_SecService;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Mageone_Qps_Model_Cron
 */
class RuleUpdateTest extends AbstractTest
{
    const RESOURCE_URL = 'https://example.com/mageone/qps';
    const RULE
        = [
            'url'          => '*adminhtml*wysiwyg/directive/index',
            'type'         => 'regex',
            'name'         => 'Block admin create via plain SQL',
            'rule_content' => '/(^([a-zA-z]+)(\\d+)?$)/u',
            'target'       => '_GET',
            'preprocess'   => self::RULE_PREPROCESS,
            'patch_fix'    => 'SUPEE-5344',
            'm1_key'       => self::RULE_KEY
        ];
    const RULE_KEY = 'MO-4711';
    const RULE_PREPROCESS = 'base64_decode';
    /**
     * @var Mageone_Qps_Model_Cron
     */
    private $cron;
    /**
     * @var Mage_HTTP_IClient|MockObject
     */
    private $clientMock;
    /**
     * @var Mageone_Qps_Model_SecService
     */
    private $secService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = $this->createMock(Mage_HTTP_IClient::class);
        $this->cron       = Mage::getModel('qps/cron', ['client' => $this->clientMock]);
        $this->secService = Mage::getModel('qps/secService');

        $this->helperMock->method('getUsername')->willReturn(self::EXAMPLE_USER);
        $this->helperMock->method('getResourceUrl')->willReturn(self::RESOURCE_URL);

        Mage::app()->cleanCache([Mageone_Qps_Model_Observer::QPS_CACHE_TAG]);
        $this->getConnection()->delete($this->getResource()->getTableName('qps/rule'));
        $this->assertEquals(0, Mage::getResourceModel('qps/rule_collection')->count());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var Mage_Core_Model_Resource $resource */
        $resource = Mage::getSingleton('core/resource');
    }

    public function testDoNothingIfNotEnabled(): void
    {
        $helperMock = $this->createMock(Mageone_Qps_Helper_Data::class);
        $helperMock->method('isEnabled')->willReturn(false);
        $this->replaceHelperWithMock($helperMock, 'qps');

        $this->clientMock
            ->expects($this->never())
            ->method('post');

        $cron = Mage::getModel('qps/cron', ['client' => $this->clientMock]);
        $cron->getRules();
    }

    public function testClientReturns200(): void
    {
        $secService       = $this->secService;
        $validatePostData = (static function ($postData) use ($secService) {
            if ($postData['user'] !== self::EXAMPLE_USER) {
                return false;
            }
            $decrypt = $secService->decryptMessage($postData['message']);
            try {
                $message = json_decode($decrypt, true, 512, JSON_THROW_ON_ERROR);

                return $message['magento_version'] === Mage::getVersion()
                    && $message['patches_list'] === ['test-patch' => 'TEST patch'];
            } catch (Exception $e) {
                return false;
            }
        });

        $this->clientMock
            ->expects($this->once())
            ->method('post')
            ->with(self::RESOURCE_URL, $this->callback($validatePostData));

        $this->clientMock
            ->expects($this->once())
            ->method('getStatus')
            ->willReturn(200);

        $this->cron->getRules();
    }

    public function testClientReturns100(): void
    {
        $secService       = $this->secService;
        $validatePostData = (static function ($postData) use ($secService) {
            if ($postData['user'] !== self::EXAMPLE_USER) {
                return false;
            }
            $decrypt = $secService->decryptMessage($postData['message']);
            try {
                $message = json_decode($decrypt, true, 512, JSON_THROW_ON_ERROR);

                return $message['magento_version'] === Mage::getVersion()
                    && $message['patches_list'] === ['test-patch' => 'TEST patch'];
            } catch (Exception $e) {
                return false;
            }
        });

        $this->clientMock
            ->expects($this->once())
            ->method('post')
            ->with(self::RESOURCE_URL, $this->callback($validatePostData));

        $this->clientMock
            ->expects($this->once())
            ->method('getStatus')
            ->willReturn(100);

        $this->cron->getRules();
    }

    public function testClientReturnsNo200(): void
    {
        $this->clientMock
            ->expects($this->once())
            ->method('post');

        $this->clientMock
            ->expects($this->exactly(2))
            ->method('getStatus')
            ->willReturn(403);

        $this->cron->getRules();
    }

    /**
     * @dataProvider getRules
     *
     * @param string[]
     */
    public function testRulesAreAutoDisabled($rules): void
    {
        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        foreach (Mage::getResourceModel('qps/rule_collection') as $rule) {
            /** @var Mageone_Qps_Model_Rule $rule */
            $this->assertFalse($rule->getEnabled());
        }
    }

    /**
     * @dataProvider getRules
     *
     * @param string[]
     */
    public function testRulesAreAutoEnabled($rules): void
    {
        $this->helperMock->method('isRuleAutoEnable')->willReturn(true);

        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        foreach (Mage::getResourceModel('qps/rule_collection') as $rule) {
            /** @var Mageone_Qps_Model_Rule $rule */
            $this->assertTrue($rule->getEnabled());
        }
    }

    /**
     * @dataProvider getRules
     *
     * @param string[]
     */
    public function testWriteNewRules($rules): void
    {
        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        $this->assertEquals(count($rules), Mage::getResourceModel('qps/rule_collection')->count());
    }

    /**
     * @dataProvider getRulesWithEnabled
     *
     * @param string[]
     * @param bool $enabled
     */
    public function testUpdateRule(array $rules, bool $enabled): void
    {
        Mage::getModel('qps/rule')
            ->setData(self::RULE)
            ->setData('enabled', $enabled)
            ->setData('preprocess', '')
            ->save();

        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        $rule = Mage::getModel('qps/rule')->load(self::RULE_KEY, 'm1_key');

        $this->assertFalse($rule->isObjectNew());
        $this->assertSame($enabled, $rule->getEnabled());
        $this->assertSame(self::RULE_PREPROCESS, $rule->getData('preprocess'));
        $this->assertSame(self::RULE_KEY, $rule->getData('m1_key'));
    }

    /**
     * @dataProvider getRules
     *
     * @param string[]
     */
    public function testDeleteRuleOnUpdate($rules): void
    {
        $key = 'something_else';
        Mage::getModel('qps/rule')
            ->setData(self::RULE)
            ->setData('m1_key', $key)
            ->save();

        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        $rule = Mage::getModel('qps/rule')->load($key, 'm1_key');

        $this->assertTrue($rule->isObjectNew());
    }

    /**
     * @return string[][]
     */
    public function getRulesWithEnabled(): array
    {
        $return = [];
        foreach ([true, false] as $enabled) {
            foreach ($this->getRules() as $key => $rule) {
                $return[$key . ($enabled ? '_enabled' : '_disabled')] = array_merge($rule, [$enabled]);
            }
        }

        return $return;
    }

    /**
     * @return string[][]
     */
    public function getRules(): array
    {
        return [
            'one rule'  => [
                [
                    self::RULE
                ]
            ],
            'two rules' => [
                [
                    self::RULE,
                    [
                        'url'          => 'catalog/product/view',
                        'type'         => 'regex',
                        'name'         => 'Example something something',
                        'rule_content' => '/^13$/u',
                        'target'       => '_GET',
                        'preprocess'   => '',
                        'patch_fix'    => '',
                        'm1_key'       => 'MO-4077'
                    ]
                ],
            ],
        ];
    }
}
