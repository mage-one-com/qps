<?php

class Mageone_Qps_Helper_Patches
{
    const MAGE_ONE_PATCH_LIST = 'mage-one/patches';

    /**
     * @return string[]
     */
    public function getPatchList()
    {
        return Mage::app()->getConfig()->getNode(self::MAGE_ONE_PATCH_LIST)->asArray();
    }
}
