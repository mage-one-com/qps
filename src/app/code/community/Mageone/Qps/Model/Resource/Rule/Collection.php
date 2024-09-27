<?php

/**
 * Class MageOne_Qps_Model_Resource_Rule_Collection
 */
class MageOne_Qps_Model_Resource_Rule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct(): void
    {
        $this->_init('qps/rule');
        $this->initCache(
            Mage::app()->getCacheInstance(),
            'm1_qps_rules',
            [MageOne_Qps_Model_Rule::CACHE_TAG, MageOne_Qps_Model_Observer::QPS_CACHE_TAG]
        );
    }
}
