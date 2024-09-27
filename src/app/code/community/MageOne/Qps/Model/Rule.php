<?php

class MageOne_Qps_Model_Rule extends Mage_Core_Model_Abstract
{
    public const TYPE_REGEX = 'regex';
    public const TYPE_CUSTOM = 'custom';

    public const CACHE_TAG = 'm1_qps_rule';
    /**
     * @var string
     */
    protected $_cacheTag = 'm1_qps_rule';
    /**
     * @var string
     */
    protected $_eventPrefix = 'm1_qps_rule';
    /**
     * @var string
     */
    protected $_eventObject = 'rule';
    /**
     * @var string[]
     */
    private $targetDefaultValues
        = [
            '_SERVER',
            '_COOKIE',
            '_REQUEST',
            '_FILES',
            '_POST',
            '_GET',
            '_ENV',
            '_SESSION',
            'php://input',
            'php://stdin',
        ];

    public function getUrl(): ?string
    {
        return $this->_getData('url');
    }

    public function setUrl(string $url): \MageOne_Qps_Model_Rule
    {
        return $this->setData('url', $url);
    }

    public function getType(): string
    {
        return (string)$this->_getData('type');
    }

    public function setType(string $type): \MageOne_Qps_Model_Rule
    {
        return $this->setData('type', $type);
    }

    public function getName(): ?string
    {
        return $this->_getData('name');
    }

    public function setName(string $name): \MageOne_Qps_Model_Rule
    {
        return $this->setData('name', $name);
    }

    public function getRuleContent(): ?string
    {
        return $this->_getData('rule_content');
    }

    public function setRuleContent(string $ruleContent): \MageOne_Qps_Model_Rule
    {
        return $this->setData('rule_content', $ruleContent);
    }

    public function getTarget(): array
    {
        $target = array_filter(explode(',', $this->_getData('target')));
        if ($target) {
            return $target;
        }

        return $this->targetDefaultValues;
    }

    public function setTarget(string $target): \MageOne_Qps_Model_Rule
    {
        foreach (explode(',', $target) as $t) {
            foreach ($this->targetDefaultValues as $global) {
                if ($this->startsWith($t, $global)) {
                    continue 2;
                }
            }
            throw new RuntimeException('Value for target is invalid.');
        }

        return $this->setData('target', $target);
    }

    public function getPreprocess(): string
    {
        return (string)$this->_getData('preprocess');
    }

    public function setPreprocess(string $preprocess): \MageOne_Qps_Model_Rule
    {
        if (!in_array($preprocess, ['base64_decode', 'json_decode', 'rawurldecode', ''])) {
            throw new InvalidArgumentException(
                sprintf('%s is no allowed value for %s', (string)$preprocess, __METHOD__)
            );
        }

        return $this->setData('preprocess', $preprocess);
    }

    public function getPatchFix(): ?string
    {
        return $this->_getData('patch_fix');
    }

    public function setPatchFix(string $patchFix): \MageOne_Qps_Model_Rule
    {
        return $this->setData('patch_fix', $patchFix);
    }

    public function getM1Key(): ?string
    {
        return $this->_getData('m1_key');
    }

    public function setM1Key(string $key): \MageOne_Qps_Model_Rule
    {
        return $this->setData('m1_key', $key);
    }

    public function getEnabled(): bool
    {
        return (bool)$this->_getData('enabled');
    }

    public function setEnabled(bool $enabled): \MageOne_Qps_Model_Rule
    {
        return $this->setData('enabled', $enabled);
    }

    protected function _construct(): void
    {
        $this->_init('qps/rule');
    }

    /**
     * @param string $string
     * @param string $startsWith
     *
     * @return bool
     */
    private function startsWith(string $string, string $startsWith): bool
    {
        return substr_compare($string, $startsWith, 0, strlen($startsWith)) === 0;
    }
}
