<?php

namespace MageOne\Qps\Test\Unit\Model;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers \Mageone_Qps_Model_Rule
 */
class RuleTest extends AbstractTest
{
    /**
     * @var \Mageone_Qps_Model_Rule
     */
    private $rule;

    /**
     * @dataProvider getMethodAndValidData
     *
     * @param string $method
     * @param string $data
     */
    public function testGetSetGet($method, $data)
    {
        $this->assertNull($this->rule->{'get' . $method}());
        $this->assertSame($this->rule, $this->rule->{'set' . $method}($data));
        $this->assertSame($data, $this->rule->{'get' . $method}());
    }

    /**
     * @return string[][]
     */
    public function getMethodAndValidData()
    {
        return [
            ['Id', 7],
            ['Url', 'adminhtml*wysiwyg/directive/index*'],
            ['Type', 'regex'],
            ['Name', 'Block admin create via plain SQL'],
            ['Rule_content', '/(^([a-zA-z]+)(\\d+)?$)/u'],
            ['Preprocess', 'base64_decode'],
            ['Preprocess', 'json_decode'],
            ['Preprocess', 'rawurldecode'],
            ['Preprocess', ''],
            ['Patch_fix', 'SUPEE-5344'],
        ];
    }

    /**
     * @param string $value
     *
     * @dataProvider getInvalidValuesForPreProcess
     */
    public function testInvalidValuesForPreprocess($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->rule->setPreprocess($value);
    }

    public function getInvalidValuesForPreProcess()
    {
        return [
            ['something_else'],
            [5],
        ];
    }

    public function testGetTargetReturnsNonEmptyArray()
    {
        $this->rule->setTarget('_GET');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['_GET'], $this->rule->getTarget());

    }

    public function testReturnsDefaultIfTargetIsEmpty()
    {
        $this->rule->getTarget();
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(
            ['_SERVER', '_COOKIE', '_REQUEST', '_FILES', '_POST', '_GET', '_ENV', '_SESSION'],
            $this->rule->getTarget()
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = \Mage::getModel('qps/rule');
    }

}
