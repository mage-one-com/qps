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
    public function getUrl()
    {
        return $this->_getData('url');
    }

    /**
     * @param string $url
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setUrl($url)
    {
        return $this->setData('url', $url);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return (string)$this->_getData('type');
    }

    /**
     * @param string $type
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setType($type)
    {
        return $this->setData('type', $type);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_getData('name');
    }

    /**
     * @param string $name
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @return string
     */
    public function getRuleContent()
    {
        return $this->_getData('rule_content');
    }

    /**
     * @param string $ruleContent
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setRuleContent($ruleContent)
    {
        return $this->setData('rule_content', $ruleContent);
    }

    /**
     * @return array
     */
    public function getTarget()
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
    public function setTarget($target)
    {
        if (!in_array($target, $this->targetDefaultValues)) {
            throw new RuntimeException('Value for target is invalid.');
        }

        return $this->setData('target', $target);
    }

    /**
     * @return string
     */
    public function getPreprocess()
    {
        return (string)$this->_getData('preprocess');
    }

    /**
     * @param string $preprocess
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setPreprocess($preprocess)
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
    public function getPatchFix()
    {
        return $this->_getData('patch_fix');
    }

    /**
     * @param string $patchFix
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setPatchFix($patchFix)
    {
        return $this->setData('patch_fix', $patchFix);
    }

    /**
     * @return string
     */
    public function getM1Key()
    {
        return $this->_getData('m1_key');
    }

    /**
     * @param string $key
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setM1Key($key)
    {
        return $this->setData('m1_key', $key);
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return (bool)$this->_getData('enabled');
    }

    /**
     * @param bool $enabled
     *
     * @return Mageone_Qps_Model_Rule
     */
    public function setEnabled($enabled)
    {
        return $this->setData('enabled', $enabled);
    }

    protected function _construct()
    {
        $this->_init('qps/rule');
    }
}
