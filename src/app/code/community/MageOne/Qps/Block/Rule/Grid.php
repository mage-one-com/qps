<?php

class MageOne_Qps_Block_Rule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setSaveParametersInSession(true);
    }

    public function getRowUrl(MageOne_Qps_Model_Rule $row): string
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

    protected function _prepareCollection(): MageOne_Qps_Block_Rule_Grid
    {
        $collection = Mage::getModel('qps/rule')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns(): MageOne_Qps_Block_Rule_Grid
    {
        $this->addColumn('m1_key',
            [
                'header' => $this->__('Identifier'),
                'type'   => 'text',
                'index'  => 'm1_key',
                'escape' => true,
            ]
        );

        $this->addColumn('url',
            [
                'header' => $this->__('Validated URL pattern'),
                'type'   => 'text',
                'index'  => 'url',
                'escape' => true,
            ]
        );

        $this->addColumn('type',
            [
                'header' => $this->__('Type'),
                'type'   => 'text',
                'index'  => 'type',
                'escape' => true,
            ]
        );

        $this->addColumn('name',
            [
                'header' => $this->__('Name'),
                'type'   => 'text',
                'index'  => 'name',
                'escape' => true,
            ]
        );

        $this->addColumn('rule_content',
            [
                'header' => $this->__('Rule Content'),
                'type'   => 'text',
                'index'  => 'rule_content',
                'escape' => true,
            ]
        );

        $this->addColumn('target',
            [
                'header' => $this->__('Target'),
                'type'   => 'text',
                'index'  => 'target',
                'escape' => true,
            ]
        );

        $this->addColumn('preprocess',
            [
                'header' => $this->__('Preprocess'),
                'type'   => 'text',
                'index'  => 'preprocess',
                'escape' => true,
            ]
        );

        $this->addColumn('patch_fix',
            [
                'header' => $this->__('Fixing Patch'),
                'type'   => 'text',
                'index'  => 'patch_fix',
                'escape' => true,
            ]
        );

        $this->addColumn('enabled',
            [
                'index'          => 'enabled',
                'header'         => $this->__('Status'),
                'width'          => '120',
                'align'          => 'left',
                'type'           => 'options',
                'options'        => [0 => $this->__('Disabled'), 1 => $this->__('Enabled')],
                'frame_callback' => [$this, 'decorateStatus']
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Decorate status column values
     *
     * @param string                 $value
     * @param MageOne_Qps_Model_Rule $row
     *
     * @return string
     */
    public function decorateStatus($value, $row): string
    {
        if ($row->getEnabled()) {
            return '<span class="grid-severity-notice"><span>' . $value . '</span></span>';
        }

        return '<span class="grid-severity-critical"><span>' . $value . '</span></span>';
    }

}
