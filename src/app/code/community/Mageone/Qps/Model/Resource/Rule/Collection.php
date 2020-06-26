<?php

/**
 * Class Mageone_Qps_Model_Resource_Rule_Collection
 */
class Mageone_Qps_Model_Resource_Rule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init("qps/rule");
    }
}
	 