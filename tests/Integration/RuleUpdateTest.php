<?php

namespace MageOne\Qps\Test\Integration;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers \Mageone_Qps_Model_Cron
 */
class RuleUpdateTest extends AbstractTest
{
    /**
     * @var \Mageone_Qps_Model_Cron
     */
    private $cron;
    /**
     * @var \Mage_HTTP_IClient|\PHPUnit\Framework\MockObject\MockObject
     */
    private $clientMock;
    /**
     * @var \Mageone_Qps_Model_SecService
     */
    private $secService;

    public function testClientReturns200()
    {
        $secService       = $this->secService;
        $validatePostData = (static function ($postData) use ($secService) {
            if ($postData['user'] !== self::EXAMPLE_USER) {
                return false;
            }
            $decrypt = $secService->decryptMessage($postData['message']);
            try {
                $message = json_decode($decrypt, true, 512, JSON_THROW_ON_ERROR);

                return $message['magento_version'] === \Mage::getVersion() && $message['patches_list'] === '';
            } catch (\Exception $e) {
                return false;
            }
        });

        $this->clientMock
            ->expects($this->once())
            ->method('post')
            ->with('https://qps.mage-one.com/update', $this->callback($validatePostData));

        $this->clientMock
            ->expects($this->once())
            ->method('getStatus')
            ->willReturn(200);

        $this->cron->getRules();
    }

    public function testClientReturnsNo200()
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
     * @param string[] $rules
     */
    public function testWriteNewRules($rules)
    {
        $this->clientMock
            ->method('getStatus')
            ->willReturn(200);

        $message = $this->secService->encryptMessage(json_encode($rules));

        $this->clientMock
            ->method('getBody')
            ->willReturn($message);

        $this->cron->getRules();

        $this->assertEquals(count($rules), \Mage::getResourceModel('qps/rule_collection')->count());
    }

    public function getRules()
    {
        return [
            'one rule'  => [
                [
                    [
                        'url'          => 'adminhtml*wysiwyg/directive/index*',
                        'type'         => 'regex',
                        'name'         => 'Block admin create via plain SQL',
                        'rule_content' => '/(^([a-zA-z]+)(\\d+)?$)/u',
                        'target'       => '_GET',
                        'preprocess'   => 'base64_decode',
                        'patch_fix'    => 'SUPEE-5344'
                    ]
                ]
            ],
            'two rules' => [
                [
                    [
                        'url'          => 'adminhtml*wysiwyg/directive/index*',
                        'type'         => 'regex',
                        'name'         => 'Block admin create via plain SQL',
                        'rule_content' => '/(^([a-zA-z]+)(\\d+)?$)/u',
                        'target'       => '_GET',
                        'preprocess'   => 'base64_decode',
                        'patch_fix'    => 'SUPEE-5344'
                    ],
                    [
                        'url'          => 'catalog/product/view',
                        'type'         => 'regex',
                        'name'         => 'Example something something',
                        'rule_content' => '/^13$/u',
                        'target'       => '_GET',
                        'preprocess'   => '',
                        'patch_fix'    => 'MO-1'
                    ]
                ],
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = $this->createMock(\Mage_HTTP_IClient::class);
        $this->cron       = \Mage::getModel('qps/cron', ['client' => $this->clientMock]);

        $this->secService = \Mage::getModel('qps/secService');
    }
}
