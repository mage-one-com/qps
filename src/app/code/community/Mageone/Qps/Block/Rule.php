<?php

class MageOne_Qps_Block_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'qps';
        $this->_controller = 'rule';
        $this->_headerText = $this->__('Mage One QPS Rules');
        parent::__construct();
        $this->removeButton('add');

        if(Mage::helper('qps')->isEnabled()){
            $this->_addButton('load_rules', array(
                'label' => $this->__('Load Rules'),
                'onclick' => "setLocation('{$this->getUrl('*/*/load')}')",
            ));
        }else {
            $this->_addButton('load_rules', array(
                'label' => $this->__('To load rules enable QPS first'),
                'onclick' => "setLocation('{$this->getUrl('*/system_config/edit/section/qps_section')}')",

            ));
        }
    }
}

