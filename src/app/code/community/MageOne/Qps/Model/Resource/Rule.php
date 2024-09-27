<?php

/**
 * Class MageOne_Qps_Model_Resource_Rule
 */
class MageOne_Qps_Model_Resource_Rule extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct(): void
    {
        $this->_init('qps/rule', 'id');
    }
}
