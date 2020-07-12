<?php

namespace MageOne\Qps\Test\Unit;

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
            ['Target', '_GET'],
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = \Mage::getModel('qps/rule');
    }

}
