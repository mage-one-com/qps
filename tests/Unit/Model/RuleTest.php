<?php

namespace MageOne\Qps\Test\Unit\Model;

use InvalidArgumentException;
use Mage;
use MageOne\Qps\Test\AbstractTest;
use Mageone_Qps_Model_Rule;
use RuntimeException;

/**
 * @covers \Mageone_Qps_Model_Rule
 */
class RuleTest extends AbstractTest
{
    /**
     * @var Mageone_Qps_Model_Rule
     */
    private $rule;

    /**
     * @dataProvider getMethodAndValidData
     *
     * @param string $method
     * @param string $data
     * @param null   $dataBefore
     */
    public function testGetSetGet($method, $data, $dataBefore = null): void
    {
        $this->assertSame($dataBefore, $this->rule->{'get' . $method}());
        $this->assertSame($this->rule, $this->rule->{'set' . $method}($data));
        $this->assertSame($data, $this->rule->{'get' . $method}());
    }

    /**
     * @return string[][]
     */
    public function getMethodAndValidData(): array
    {
        return [
            'id'           => ['Id', 7],
            'url'          => ['Url', 'adminhtml*wysiwyg/directive/index*'],
            'type'         => ['Type', 'regex', ''],
            'name'         => ['Name', 'Block admin create via plain SQL'],
            'rule_content' => ['RuleContent', '/(^([a-zA-z]+)(\\d+)?$)/u'],
            'preprocess_1' => ['Preprocess', 'base64_decode', ''],
            'preprocess_2' => ['Preprocess', 'json_decode', ''],
            'preprocess_3' => ['Preprocess', 'rawurldecode', ''],
            'preprocess_4' => ['Preprocess', '', ''],
            'patch_fix'    => ['PatchFix', 'SUPEE-5344'],
            'm1_key'       => ['M1Key', 'MO-1'],
            'enabled'      => ['Enabled', true, false],
        ];
    }

    /**
     * @param string $value
     *
     * @dataProvider getInvalidValuesForPreProcess
     */
    public function testInvalidValuesForPreprocess($value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->rule->setPreprocess($value);
    }

    public function getInvalidValuesForPreProcess(): array
    {
        return [
            ['something_else'],
            [5],
        ];
    }

    public function testSetTargetForNonTrivialPattern(): void
    {
        $this->rule->setTarget('_GET[\'one\'][\'two\'][\'three\'][\'four\']');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['_GET[\'one\'][\'two\'][\'three\'][\'four\']'], $this->rule->getTarget());
    }

    public function testSetTargetForMultiplePattern(): void
    {
        $this->rule->setTarget('_GET[\'one\'][\'two\'],_SERVER,_POST');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['_GET[\'one\'][\'two\']', '_SERVER', '_POST'], $this->rule->getTarget());
    }

    public function testGetTargetReturnsNonEmptyArray(): void
    {
        $this->rule->setTarget('_GET');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['_GET'], $this->rule->getTarget());
    }

    public function testGetTargetReturnsPhpInput(): void
    {
        $this->rule->setTarget('php://input');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['php://input'], $this->rule->getTarget());
    }

    public function testGetTargetReturnsPhpStdin(): void
    {
        $this->rule->setTarget('php://stdin');
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(['php://stdin'], $this->rule->getTarget());
    }

    public function testReturnsDefaultIfTargetIsEmpty(): void
    {
        $this->rule->getTarget();
        $this->assertIsArray($this->rule->getTarget());
        $this->assertSame(
            [
                '_SERVER',
                '_COOKIE',
                '_REQUEST',
                '_FILES',
                '_POST',
                '_GET',
                '_ENV',
                '_SESSION',
                'php://input',
                'php://stdin'
            ],
            $this->rule->getTarget()
        );
    }

    public function testThrowsExceptionOnInvalidTarget(): void
    {
        $this->expectException(RuntimeException::class);
        $this->rule->setTarget('something_invalid');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = Mage::getModel('qps/rule');
    }

}
