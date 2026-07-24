<?php

namespace MageOne\Qps\Test\Unit\Helper;

use InvalidArgumentException;
use Mage;
use MageOne\Qps\Test\AbstractTest;
use MageOne_Qps_Helper_GlobalGetter;
use stdClass;

/**
 * @covers MageOne_Qps_Helper_GlobalGetter
 */
class GlobalGetterTest extends AbstractTest
{
    /**
     * @var MageOne_Qps_Helper_GlobalGetter
     */
    private $helper;

    protected $backupGlobals = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = new MageOne_Qps_Helper_GlobalGetter();
    }

    public function testCreateHelperViaMageHelper(): void
    {
        $this->assertInstanceOf(MageOne_Qps_Helper_GlobalGetter::class, Mage::helper('qps/globalGetter'));
    }

    public function testGetWithSingleQuote(): void
    {
        $value                        = '123';
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'something\']'));
    }

    public function testGetWithDoubleQuote(): void
    {
        $value                        = '123';
        $GLOBALS['_GET']['something'] = $value;

        $this->assertSame($value, $this->helper->get('_GET["something"]'));
    }

    public function testGetWithDeepArray(): void
    {
        $value                                          = '1234';
        $GLOBALS['_GET']['one']['two']['three']['four'] = $value;

        $this->assertSame($value, $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));
    }

    public function testReturnsEmptyStringIfUndefined(): void
    {
        $this->assertSame('', $this->helper->get('_GET[\'one\'][\'two\'][\'three\'][\'four\']'));

    }

    public function testThrowsExceptionIfExprIsNoString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertSame('', $this->helper->get(new stdClass()));
    }

    public function testReturnsPhpInput(): void
    {
        $expected = '12345';
        $getter   = new MageOne_Qps_Helper_GlobalGetter(static function () use ($expected) {
            return $expected;
        });

        $this->assertSame($expected, $getter->get('php://input'));
    }

    public function testReturnsPhpStdin(): void
    {
        $expected = 'lalala';
        $getter   = new MageOne_Qps_Helper_GlobalGetter(null, static function () use ($expected) {
            return $expected;
        });

        $this->assertSame($expected, $getter->get('php://stdin'));
    }

    public function testIndexedArrayValueIsFlattened(): void
    {
        $GLOBALS['_GET']['email'] = ["1' UNION SELECT * FROM admin_user--"];

        $result = $this->helper->get('_GET[\'email\']');

        $this->assertNotSame('Array', $result);
        $this->assertSame("1' UNION SELECT * FROM admin_user--", $result);
    }

    public function testAssociativeArrayValueIsFlattened(): void
    {
        $GLOBALS['_GET']['email'] = ['from' => '', 'to' => 'UNION SELECT'];

        $result = $this->helper->get('_GET[\'email\']');

        $this->assertNotSame('Array', $result);
        $this->assertStringContainsString('UNION SELECT', $result);
    }

    public function testDeeplyNestedArrayIsFlattened(): void
    {
        $GLOBALS['_POST']['filter'] = [['nested_payload']];

        $result = $this->helper->get('_POST[\'filter\']');

        $this->assertNotSame('Array', $result);
        $this->assertSame('nested_payload', $result);
    }

    public function testArrayNestingBeyondTenLevelsIsNotIgnored(): void
    {
        $deep = 'deep_payload';
        $nested = $deep;
        for ($i = 0; $i < 12; $i++) {
            $nested = [$nested];
        }
        $GLOBALS['_GET']['param'] = $nested;

        $result = $this->helper->get('_GET[\'param\']');

        $this->assertNotSame('Array', $result);
        $this->assertNotSame('', $result);
        $this->assertSame($deep, $result);
    }
}
