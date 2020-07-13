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
    public function testGetSetGet($method, $data, $dataBefore = null)
    {
        $this->assertSame($dataBefore, $this->rule->{'get' . $method}());
        $this->assertSame($this->rule, $this->rule->{'set' . $method}($data));
        $this->assertSame($data, $this->rule->{'get' . $method}());
    }

    /**
     * @return string[][]
     */
    public function getMethodAndValidData()
    {
        return [
            'id'           => ['Id', 7],
            'url'          => ['Url', 'adminhtml*wysiwyg/directive/index*'],
            'type'         => ['Type', 'regex', ''],
            'name'         => ['Name', 'Block admin create via plain SQL'],
            'rule_content' => ['Rule_content', '/(^([a-zA-z]+)(\\d+)?$)/u'],
            'preprocess_1' => ['Preprocess', 'base64_decode', ''],
            'preprocess_2' => ['Preprocess', 'json_decode', ''],
            'preprocess_3' => ['Preprocess', 'rawurldecode', ''],
            'preprocess_4' => ['Preprocess', '', ''],
            'patch_fix'    => ['Patch_fix', 'SUPEE-5344'],
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

    public function testGetTargetReturnsPhpInput()
    {
        $this->rule->setTarget('php://input');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['php://input'], $this->rule->getTarget());
    }

    public function testReturnsDefaultIfTargetIsEmpty()
    {
        $this->rule->getTarget();
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(
            ['_SERVER', '_COOKIE', '_REQUEST', '_FILES', '_POST', '_GET', '_ENV', '_SESSION', 'php://input'],
            $this->rule->getTarget()
        );
    }

    public function testThrowsExceptionOnInvalidTarget()
    {
        $this->expectException(\RuntimeException::class);
        $this->rule->setTarget('something_invalid');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = \Mage::getModel('qps/rule');
    }

}
