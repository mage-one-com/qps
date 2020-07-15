<?php

class Mageone_Qps_Block_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'qps';
        $this->_controller = 'rule';
        $this->_headerText = $this->__('Mage One QPS Rules');
        parent::__construct();

        $this->removeButton('add');
    }
}

