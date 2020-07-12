<?php

class Mageone_Qps_Helper_Data extends Mage_Core_Helper_Abstract
{
    const QPS_URL = 'qps_section/config/url';
    const QPS_STATUS = 'qps_section/config/status';
    const QPS_PUBLIC_KEY = 'qps_section/config/public_key';
    const QPS_PRIVATE_KEY = 'qps_section/config/private_key';
    const QPS_USER = 'qps_section/config/user_name';

    public function isEnabled()
    {
        return Mage::getStoreConfigFlag(self::QPS_STATUS);
    }

    public function getPublicKey()
    {
        return trim(Mage::getStoreConfig(self::QPS_PUBLIC_KEY));
    }

    public function getPrivateKey()
    {
        return trim(Mage::getStoreConfig(self::QPS_PRIVATE_KEY));
    }

    public function getResourceUrl()
    {
        return trim(Mage::getStoreConfig(self::QPS_URL));
    }

    public function getUserName()
    {
        return trim(Mage::getStoreConfig(self::QPS_USER));
    }
}
