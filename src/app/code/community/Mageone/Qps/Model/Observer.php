<?php

if (!defined('JSON_THROW_ON_ERROR')) {
    define('JSON_THROW_ON_ERROR', 4194304);
}

/**
 * Class Mageone_Qps_Model_Observer
 */
class Mageone_Qps_Model_Observer
{
    const QPS_CACHE = 'qps_security';
    const QPS_CACHE_TAG = 'qps';
    const QPS_LOG = 'qps.log';

    const ADMINHTML_PATH_PATTERN = '*adminhtml*';

    /**
     * @var Mageone_Qps_Model_Resource_Rule_Collection
     */
    private $rules;

    public function checkRequest(Varien_Event_Observer $observer)
    {
        Varien_Profiler::start(__METHOD__);
        /** @var Mage_Core_Controller_Varien_Front $frontAction */
        $frontAction = $observer->getFront();
        $request     = $frontAction->getRequest();
        if (!Mage::helper('qps')->isEnabled()) {
            return;
        }

        if ($this->getRules()->count() === 0) {
            return;
        }

        $this->validate($request);
        Varien_Profiler::stop(__METHOD__);
    }

    /**
     * @return Mageone_Qps_Model_Resource_Rule_Collection
     */
    private function getRules()
    {
        if (!$this->rules) {
            $this->rules = Mage::getResourceModel('qps/rule_collection');
        }

        return $this->rules;
    }

    private function validate(Mage_Core_Controller_Request_Http $request)
    {
        try {
            foreach ($this->getRules() as $rule) {
                try {
                    $this->validateRule($rule, $request);
                } catch (Mageone_Qps_Model_Exception_RuleNotPassedException $e) {
                    $this->processTriggeredRule();
                }
            }
        } catch (Mageone_Qps_Model_Exception_ExitSkippedForTestingException $e) {
            throw $e;
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    private function validateRule(Mageone_Qps_Model_Rule $rule, Mage_Core_Controller_Request_Http $request)
    {
        if (!$this->isUrlMatch($rule, $request)) {
            return true;
        }

        // we don't test for already fixed vulnerabilities,
        //because getting a list of installed patches takes
        // longer then just running the regex

        $regex = $rule->getRuleContent();
        foreach ($rule->getTarget() as $target) {
            $targetValue = $this->preprocessValue($this->getValueFromGlobal($target), $rule->getPreprocess());
            if ($rule->getType() === Mageone_Qps_Model_Rule::TYPE_REGEX) {
                $this->validateRegexRule($rule, $targetValue);
            } else {
                $transportObject = new Varien_Object();
                $transportObject->setData(
                    ['rule' => $rule, 'value' => $targetValue, 'passed' => true]
                );
                Mage::dispatchEvent(
                    'qps_custom_check',
                    $transportObject
                );
                if (!$transportObject->getData('passed')) {
                    $this->processTriggeredRule();
                }
            }
        }
    }

    /**
     * @param Mageone_Qps_Model_Rule            $rule
     * @param Mage_Core_Controller_Request_Http $request
     *
     * @return bool
     */
    private function isUrlMatch(Mageone_Qps_Model_Rule $rule, Mage_Core_Controller_Request_Http $request)
    {
        $path = (string)Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME);
        $url  = str_replace(self::ADMINHTML_PATH_PATTERN, $path, $rule->getUrl());

        return strpos($request->getRequestUri(), $url) !== false;
    }

    /**
     * @param string $value
     * @param string $action
     *
     * @return string
     */
    private function preprocessValue($value, $action)
    {
        switch ($action) {
            case 'base64_decode':
                return base64_decode($value);
            case 'json_decode':
                // TODO not accessable currently!
                return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            case 'rawurldecode':
            case '':
            default:
                return $value;
        }
    }

    /**
     * @param string $expr
     *
     * @return string
     */
    private function getValueFromGlobal($expr)
    {
        return (string)Mage::helper('qps/globalGetter')->get($expr);
    }

    private function validateRegexRule(Mageone_Qps_Model_Rule $rule, $targetValue)
    {
        if (preg_match($rule->getRuleContent(), $targetValue)) {
            $this->processTriggeredRule();
        }
    }

    private function processTriggeredRule()
    {
        if (defined('TESTING')) {
            throw new Mageone_Qps_Model_Exception_ExitSkippedForTestingException(
                'Rule did not pass.'
            );
        }
        Mage::log('Bad request from: ' . Mage::app()->getRequest()->getClientIp(true), Zend_Log::ALERT, self::QPS_LOG);
        Mage::app()->getResponse()->setHttpResponseCode(503)->sendHeaders();
        exit;
    }
}
