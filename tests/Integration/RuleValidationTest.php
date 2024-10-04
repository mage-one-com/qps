<?php

namespace MageOne\Qps\Test\Integration;

require __DIR__ . '/_MageOne_Test_Observer.php';

use Mage;
use Mage_Adminhtml_Helper_Data;
use Mage_Core_Controller_Request_Http;
use Mage_Core_Controller_Varien_Front;
use MageOne\Qps\Test\AbstractTest;
use MageOne_Qps_Helper_Data;
use MageOne_Qps_Model_Exception_ExitSkippedForTestingException;
use MageOne_Qps_Model_Observer;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;
use Varien_Event_Observer;

/**
 * @covers \MageOne_Qps_Model_Observer
 */
class RuleValidationTest extends AbstractTest
{
    protected $backupGlobals = true;
    /**
     * @var MageOne_Qps_Model_Observer
     */
    private $observer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->observer = Mage::getModel('qps/observer');
    }

    public function testDoesNothingIfDisabled(): void
    {
        $helperMock = $this->createMock(MageOne_Qps_Helper_Data::class);
        $helperMock->method('isEnabled')->willReturn(false);
        $this->replaceHelperWithMock($helperMock, 'qps');

        $this->createRule('/', 'Custom URL which never matches', '#^value$#', '_GET["key"]', '', 'MO-1');
        $request = $this->setupRequest('/', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));

        /*
         * same as: RuleValidationTest::testRuleDoesTriggerIfUrlDoesMatch
         * but we don't expect an exception.
         */
        $this->assertTrue(true, 'We expect that no exception is thrown');
    }

    public function testRuleIsNotValidatedIfDisabled(): void
    {
        $this->createRule('/', 'Custom URL which never matches', '#^value$#', '_GET["key"]', '', 'MO-1', 0);
        $request = $this->setupRequest('/', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));

        /*
         * Rule is disabled, therefore we don't expect an exception
         */
        $this->assertTrue(true, 'We expect that no exception is thrown');
    }

    public function testRuleDoesNotTriggerIfUrlDoesNotMatch(): void
    {
        $this->createRule(
            '/url/does/not/match',
            'Custom URL which never matches',
            '#^value$#',
            '_GET["key"]',
            '',
            'MO-1'
        );
        $request = $this->setupRequest('/', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));

        $this->assertTrue(true, 'We expect that no exception is thrown');
    }

    public function testRuleDoesTriggerIfUrlDoesMatch(): void
    {
        $this->expectException(MageOne_Qps_Model_Exception_ExitSkippedForTestingException::class);

        $this->createRule('/', 'Custom URL which never matches', '#^value$#', '_GET["key"]', '', 'MO-1');
        $request = $this->setupRequest('/', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));
    }

    public function testEmptyUrlMatchesEverything(): void
    {
        $this->expectException(MageOne_Qps_Model_Exception_ExitSkippedForTestingException::class);

        $this->createRule('', 'Custom URL which never matches', '#^value$#', '_GET["key"]', '', 'MO-1');
        $request = $this->setupRequest('/some/url', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));
    }

    public function testRuleDoesTriggerEventIfNotRegex(): void
    {
        $called = \MageOne_Test_Observer::$called;

        $path = 'global/events/m1_qps_custom_check/observers/mage_one/';
        Mage::app()->getConfig()->setNode($path . 'type', 'singleton');
        Mage::app()->getConfig()->setNode($path . 'class', 'MageOne_Test_Observer');
        Mage::app()->getConfig()->setNode($path . 'method', 'qpsCustomCheck');

        $refProp = new \ReflectionProperty(Mage::app()->getConfig(), '_eventAreas');
        $refProp->setAccessible(true);
        $refProp->setValue(Mage::app()->getConfig(), null);
        $refProp->setAccessible(false);

        $this->expectException(MageOne_Qps_Model_Exception_ExitSkippedForTestingException::class);

        $this->createRule(
            '/', 'Custom URL which never matches', '#^value$#', '_GET["key"]', '', 'MO-1', 1, 'something-else'
        );
        $request = $this->setupRequest('/', ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));
        $this->assertSame($called + 1, \MageOne_Test_Observer::$called);
    }

    public function testAdminhtmlReplacementWorks(): void
    {
        $adminPath = $this->getAdminPath();

        $this->expectException(MageOne_Qps_Model_Exception_ExitSkippedForTestingException::class);

        $this->createRule(
            '/*adminhtml*/customer/index/',
            'Custom URL which never matches',
            '#^value$#',
            '_GET["key"]',
            '',
            'MO-1'
        );
        $request = $this->setupRequest("/$adminPath/customer/index/", ['key' => 'value'], []);
        $this->observer->checkRequest($this->setupEvent($request));
    }

    public function testPreprocessBase64Decode(): void
    {
        $this->expectException(MageOne_Qps_Model_Exception_ExitSkippedForTestingException::class);

        $this->createRule(
            '/checkout/cart/add/',
            'Custom URL which never matches',
            '#core_config_data#',
            '_GET["config"]',
            'base64_decode',
            'MO-1'
        );
        $request = $this->setupRequest(
            '/checkout/cart/add/',
            [
                'id'     => '7',
                'config' => base64_encode(
                    'INSERT INTO `core_config_data` SET `value` = \'<script>\'WHERE `path` = \'design/footer/absolute_footer\''
                )
            ],
            []
        );
        $this->observer->checkRequest($this->setupEvent($request));
    }

    private function createRule(
        $url,
        $name,
        $content,
        $target,
        $preprocess,
        $patchFix,
        $enabled = 1,
        $type = 'regex'
    ): void {
        Mage::getModel('qps/rule')->setData([
            //`url` varchar(255) DEFAULT NULL COMMENT 'specific URL utilized by threat covered if present, adminhtml placeholder represents adminhtml path in current magento installation, optional.',
            'url'          => $url,
            //`type` text COMMENT 'rule type (regex|custom), custom rules reserved for future purpose and not covered in this document, mandatory.',
            'type'         => $type,
            //`name` varchar(255) DEFAULT '' COMMENT 'rule title, optional',
            'name'         => $name,
            //`rule_content` text COMMENT 'regex string for request validation, custom rules could have more complex data like json object, mandatory.',
            'rule_content' => $content,
            //`target` text COMMENT 'explain which request part should be checked. Possible values are all headers (or specific header), post and get data, cookies and session variables (see REQUEST arrays and rules examples below), comma separated for multiple values. Whole request will be checked if not specified, optional.',
            'target'       => $target,
            //`preprocess` text COMMENT 'name of the function executed on raw target values, (base64_decode|json_decode|rawurldecode), optional.',
            'preprocess'   => $preprocess,
            //`patch_fix` text COMMENT 'patch that covers rule related threat, no need to check rule if customer magento 1 have this patch, optional',
            'patch_fix'    => $patchFix,
            'enabled'      => $enabled
        ])->save();
    }

    /**
     * @param Mage_Core_Controller_Request_Http $request
     *
     * @return Varien_Event_Observer
     */
    private function setupEvent(Mage_Core_Controller_Request_Http $request)
    {
        $front = $this->createMock(Mage_Core_Controller_Varien_Front::class);
        $front->method('getRequest')->willReturn($request);
        /** @var MockObject|Varien_Event_Observer $observer */
        $observer = $this->getMockBuilder(Varien_Event_Observer::class)
            ->addMethods(['getFront'])
            ->getMock();
        $observer->method('getFront')->willReturn($front);

        return $observer;
    }

    /**
     * @param string $url
     * @param array  $get
     * @param array  $post
     *
     * @return Mage_Core_Controller_Request_Http|MockObject
     */
    private function setupRequest($url, $get, $post)
    {
        $GLOBALS['_GET']  = $get;
        $GLOBALS['_POST'] = $post;

        $mock = $this->createMock(Mage_Core_Controller_Request_Http::class);
        $mock->method('getRequestUri')->willReturn($url);

        return $mock;
    }

    /**
     * @return string
     */
    private function getAdminPath(): string
    {
        $adminUrl = Mage_Adminhtml_Helper_Data::getUrl('adminhtml');
        $baseUrl  = Mage::getBaseUrl();

        if (!preg_match("#{$baseUrl}([a-zA-Z0-9]*)/index/index/#", $adminUrl, $matches)) {
            throw new RuntimeException('Can\'t determine admin path.');
        }

        return $matches[1];
    }
}
