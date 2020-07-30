<?php

class Mageone_Qps_Model_Rule extends Mage_Core_Model_Abstract
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

    public function setUrl(string $url): \Mageone_Qps_Model_Rule
    {
        return $this->setData('url', $url);
    }

    public function getType(): string
    {
        return (string)$this->_getData('type');
    }

    public function setType(string $type): \Mageone_Qps_Model_Rule
    {
        return $this->setData('type', $type);
    }

    public function getName(): ?string
    {
        return $this->_getData('name');
    }

    public function setName(string $name): \Mageone_Qps_Model_Rule
    {
        return $this->setData('name', $name);
    }

    public function getRuleContent(): ?string
    {
        return $this->_getData('rule_content');
    }

    public function setRuleContent(string $ruleContent): \Mageone_Qps_Model_Rule
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

    public function setTarget(string $target): \Mageone_Qps_Model_Rule
    {
        $targets = explode(',', $target);
        foreach ($targets as $t) {
            foreach ($this->targetDefaultValues as $global) {
                if (substr_compare($t, $global, 0, strlen($global)) === 0) {
                    break 2;
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

    public function setPreprocess(string $preprocess): \Mageone_Qps_Model_Rule
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

    public function setPatchFix(string $patchFix): \Mageone_Qps_Model_Rule
    {
        return $this->setData('patch_fix', $patchFix);
    }

    public function getM1Key(): ?string
    {
        return $this->_getData('m1_key');
    }

    public function setM1Key(string $key): \Mageone_Qps_Model_Rule
    {
        return $this->setData('m1_key', $key);
    }

    public function getEnabled(): bool
    {
        return (bool)$this->_getData('enabled');
    }

    public function setEnabled(bool $enabled): \Mageone_Qps_Model_Rule
    {
        return $this->setData('enabled', $enabled);
    }

    protected function _construct(): void
    {
        $this->_init('qps/rule');
    }
}
