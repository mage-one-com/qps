<?php

class MageOne_Qps_Helper_Data extends Mage_Core_Helper_Abstract
{
    const QPS_URL = 'qps_section/config/url';
    const QPS_STATUS = 'qps_section/config/status';
    const QPS_PUBLIC_KEY = 'qps_section/config/public_key';
    const QPS_USER = 'qps_section/config/user_name';
    const QPS_RULE_AUTO_ENABLE = 'qps_section/config/rule_auto_enable';
    const NOTIFICATION_STATUS = 'qps_section/notification/enabled';
    const NOTIFICATION_EMAIL = 'qps_section/notification/email';

    /**
     * @return bool
     */
    public function isNotificationEnabled(): bool
    {
        return Mage::getStoreConfigFlag(self::NOTIFICATION_STATUS);
    }

    /**
     * @return string
     */
    public function getNotificationEmail(): string
    {
        return Mage::getStoreConfig(self::NOTIFICATION_EMAIL);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return Mage::getStoreConfigFlag(self::QPS_STATUS);
    }

    /**
     * @return bool
     */
    public function isRuleAutoEnable(): bool
    {
        return Mage::getStoreConfigFlag(self::QPS_RULE_AUTO_ENABLE);
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return trim(Mage::getStoreConfig(self::QPS_PUBLIC_KEY));
    }

    /**
     * @return string
     */
    public function getResourceUrl(): string
    {
        return trim(Mage::getStoreConfig(self::QPS_URL));
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return trim(Mage::getStoreConfig(self::QPS_USER));
    }
}
