<?php

/**
 * Class Mageone_Qps_Model_Rule
 */
class Mageone_Qps_Model_Rule extends Mage_Core_Model_Abstract
{
    public function getUrl()
    {
        return $this->_getData('url');
    }

    public function setUrl($url)
    {
        return $this->setData('url', $url);
    }

    public function getType()
    {
        return $this->_getData('type');
    }

    public function setType($type)
    {
        return $this->setData('type', $type);
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    public function getRuleContent()
    {
        return $this->_getData('rule_content');
    }

    public function setRuleContent($ruleContent)
    {
        return $this->setData('rule_content', $ruleContent);
    }

    public function getTarget()
    {
        return $this->_getData('target');
    }

    public function setTarget($target)
    {
        return $this->setData('target', $target);
    }

    public function getPreprocess()
    {
        return $this->_getData('preprocess');
    }

    public function setPreprocess($preprocess)
    {
        return $this->setData('preprocess', $preprocess);
    }

    public function getPatchFix()
    {
        return $this->_getData('patch_fix');
    }

    public function setPatchFix($patchFix)
    {
        return $this->setData('patch_fix', $patchFix);
    }

    protected function _construct()
    {
        $this->_init('qps/rule');
    }

}
