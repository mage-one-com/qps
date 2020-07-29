<?php

/**
 * Class Mageone_Qps_Model_Resource_Rule
 */
class Mageone_Qps_Model_Resource_Rule extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct(): void
    {
        $this->_init('qps/rule', 'id');
    }
}
