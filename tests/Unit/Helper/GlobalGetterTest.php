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

    protected $backupGlobals = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new \Mageone_Qps_Helper_GlobalGetter();
    }

    public function testCreateHelperViaMageHelper()
    {
        $this->assertInstanceOf(\Mageone_Qps_Helper_GlobalGetter::class, \Mage::helper('qps/globalGetter'));
    }

    public function testGetWithSingleQuote()
    {
        $value                        = '123';
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'something\']'));
    }

    public function testGetWithDoubleQuote()
    {
        $value                        = '123';
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET["something"]'));
    }

    public function testGetWithDeepArray()
    {
        $value                                          = '1234';
        $GLOBALS['_GET']['one']['two']['three']['four'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));
    }

    public function testReturnsEmptyStringIfUndefined()
    {
        $this->assertSame('', $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));

    }

    public function testThrowsExceptionIfExprIsNoString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertSame('', $this->helper->get(new \stdClass()));
    }

    public function testReturnsPhpInput()
    {
        $expected = '12345';
        $getter   = new \Mageone_Qps_Helper_GlobalGetter(static function () use ($expected) {
            return $expected;
        });

        $this->assertSame($expected, $getter->get('php://input'));
    }

    public function testReturnsPhpStdin()
    {
        $expected = 'lalala';
        $getter   = new \Mageone_Qps_Helper_GlobalGetter(null, static function () use ($expected) {
            return $expected;
        });

        $this->assertSame($expected, $getter->get('php://stdin'));
    }
}
