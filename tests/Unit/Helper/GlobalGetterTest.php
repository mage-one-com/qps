<?php

namespace MageOne\Qps\Test\Unit\Helper;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers Mageone_Qps_Helper_GlobalGetter
 */
class GlobalGetterTest extends AbstractTest
{
    /**
     * @var Mageone_Qps_Helper_GlobalGetter
     */
    private $helper;

    protected $backupGlobals = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = \Mage::helper('qps/globalGetter');
    }

    public function testGetWithSingleQuote()
    {
        $value                        = 123;
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'something\']'));
    }

    public function testGetWithDoubleQuote()
    {
        $value                        = 123;
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET["something"]'));
    }

    public function testGetWithDeepArray()
    {
        $value                                          = 1234;
        $GLOBALS['_GET']['one']['two']['three']['four'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));
    }

    public function testReturnsEmptyStringIfUndefined()
    {
        $this->assertSame('', $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));
    }
}
