<?php

class Mageone_Qps_Model_Rule extends Mage_Core_Model_Abstract
{
    const TYPE_REGEX = 'regex';
    const TYPE_CUSTOM = 'custom';

    const CACHE_TAG = 'm1_qps_rule';
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

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->_getData('url');
    }

    /**
     * @param string $url
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setUrl($url): \Mageone_Qps_Model_Rule
    {
        return $this->setData('url', $url);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->_getData('type');
    }

    /**
     * @param string $type
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setType($type): \Mageone_Qps_Model_Rule
    {
        return $this->setData('type', $type);
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->_getData('name');
    }

    /**
     * @param string $name
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setName($name): \Mageone_Qps_Model_Rule
    {
        return $this->setData('name', $name);
    }

    /**
     * @return string
     */
    public function getRuleContent(): ?string
    {
        return $this->_getData('rule_content');
    }

    /**
     * @param string $ruleContent
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setRuleContent($ruleContent): \Mageone_Qps_Model_Rule
    {
        return $this->setData('rule_content', $ruleContent);
    }

    /**
     * @return array
     */
    public function getTarget(): array
    {
        $target = array_filter(explode(',', $this->_getData('target')));
        if ($target) {
            return $target;
        }

        return $this->targetDefaultValues;
    }

    /**
     * @param string $target
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setTarget($target): \Mageone_Qps_Model_Rule
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

    /**
     * @return string
     */
    public function getPreprocess(): string
    {
        return (string)$this->_getData('preprocess');
    }

    /**
     * @param string $preprocess
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setPreprocess($preprocess): \Mageone_Qps_Model_Rule
    {
        if (!in_array($preprocess, ['base64_decode', 'json_decode', 'rawurldecode', ''])) {
            throw new InvalidArgumentException(
                sprintf('%s is no allowed value for %s', (string)$preprocess, __METHOD__)
            );
        }

        return $this->setData('preprocess', $preprocess);
    }

    /**
     * @return string
     */
    public function getPatchFix(): ?string
    {
        return $this->_getData('patch_fix');
    }

    public function setPatchFix(string $patchFix): \Mageone_Qps_Model_Rule
    {
        return $this->setData('patch_fix', $patchFix);
    }

    /**
     * @return string
     */
    public function getM1Key(): ?string
    {
        return $this->_getData('m1_key');
    }

    /**
     * @param string $key
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setM1Key($key): \Mageone_Qps_Model_Rule
    {
        return $this->setData('m1_key', $key);
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return (bool)$this->_getData('enabled');
    }

    /**
     * @param bool $enabled
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setEnabled(bool $enabled): \Mageone_Qps_Model_Rule
    {
        return $this->setData('enabled', $enabled);
    }

    protected function _construct(): void
    {
        $this->_init('qps/rule');
    }
}
