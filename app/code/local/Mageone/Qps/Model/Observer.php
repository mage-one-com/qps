<?php

/**
 * Class Mageone_Qps_Model_Observer
 */
class Mageone_Qps_Model_Observer
{
    const QPS_CACHE = 'qps_security';
    const QPS_CACHE_TAG = 'qps';
    const QPS_LOG = 'qps.log';

    private $rules = [];

    public function checkRequest(Varien_Event_Observer $observer)
    {
        if (!Mage::helper("qps")->isEnabled()) {
            return null;
        }
        $checkArray = array($_SERVER, $_COOKIE, $_REQUEST, $_FILES, $_POST, $_GET, $_ENV);
        if (session_status() == PHP_SESSION_ACTIVE) {
            $checkArray[] = $_SESSION;
        }

        if ($this->getRules() && is_array($this->getRules())) {
            foreach ($checkArray as $data) {
                $this->checkGlobalArrayData($data);
            }
        }
        return $this;
    }

    private function checkGlobalArrayData($data)
    {
        try {
            foreach ($data as $key => $value) {
                foreach ($this->getRules() as $rule) {
                    $isPassed = $this->checkRule($rule, $key, $value);
                    if (!$isPassed) {
                        $this->processTriggeredRule($rule);
                    }
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return;
    }

    private function checkRule($rule, $key, $value)
    {
        if (isset($rule["target"])) {
            $parts = explode(',', $rule["target"]);
            if (!is_array($parts)) {
                $parts = [$parts];
            }
            $valid = true;
            foreach ($parts as $part) {
                $value = $this->getValue($part, $value, $rule);
                $matches = array();
                if ($rule['type'] == 'regex') {
                    preg_match_all($rule['rule_content'], $value, $matches);
                    if (isset($matches[0]) && count($matches[0])) {
                        Mage::log('Bad request : ' . $value, Zend_Log::ALERT, self::QPS_LOG);
                        $valid = false;
                    }
                } else {
                    Mage::dispatchEvent('qps_custom_check', array('rule' => $rule, 'key' => $key, 'value' => $value, 'valid' => $valid));
                }
                return $valid;
            }
        }
    }

    private function processTriggeredRule($rule)
    {
        Mage::log('Bad request from: ' . Mage::app()->getRequest()->getClientIp(true), Zend_Log::ALERT, self::QPS_LOG);
        Mage::app()->getResponse()->setHttpResponseCode(503)->sendHeaders();
        exit;
    }

    private function getValueFromGlobal($key)
    {
        $start = mb_strpos($key, '[');
        $end = mb_strpos($key, ']');
        if ($start !== false && $end !== false) {
            $global = mb_substr($key, 0, $start);
            $globalKey = mb_substr($key, $start + 2, $end - $start - 3);
            if (!empty($global) && !empty($globalKey) &&
                isset($GLOBALS[$global]) && isset($GLOBALS[$global][$globalKey])
            ) {
                return $GLOBALS[$global][$globalKey];
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    private function getCollection()
    {
        return Mage::getResourceModel('qps/rule_collection')->getData();
    }

    /**
     * @return array
     */
    private function getRules()
    {
        if (empty($this->rules)) {
            $this->rules = $this->getCachedData();
        }
        return $this->rules;
    }

    /**
     * @return array
     */
    private function getCachedData()
    {
        if (Mage::helper('pagecache')->isEnabled()) {
            if (Mage::app()->loadCache(self::QPS_CACHE) === false) {
                $data = $this->getCollection();
                Mage::app()->saveCache(Mage::helper('core')->jsonEncode($data), self::QPS_CACHE, [self::QPS_CACHE_TAG]);
            } else {
                $data = Mage::helper('core')->jsonDecode(Mage::app()->loadCache(self::QPS_CACHE));
            }
        } else {
            $data = $this->getCollection();
        }
        return $data;
    }

    /**
     * @param string $part
     * @param bool $value
     * @param $rule
     * @return bool|false|mixed|string
     */
    private function getValue($part, $value, $rule)
    {
        $value = $this->getValueFromGlobal($part);
        if ($value === false)
            return false;
        switch ($rule) {
            case 'base64_decode':
                return base64_decode($value);
                break;
            case 'json_decode':
                return Mage::helper('core')->jsonDecode($value);
                break;
            case 'rawurldecode':
            default:
                return $value;
        }

    }
}
