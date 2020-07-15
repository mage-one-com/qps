<?php

class Mageone_Qps_Block_Rule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @param Mageone_Qps_Model_Rule $row
     *
     * @return string
     */
    public function getRowUrl(Mageone_Qps_Model_Rule $row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

    /**
     * @return Mageone_Qps_Block_Rule_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('qps/rule')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Mageone_Qps_Block_Rule_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('m1_key',
            [
                'header' => $this->__('Identifier'),
                'type'   => 'text',
                'index'  => 'm1_key',
            ]
        );

        $this->addColumn('url',
            [
                'header' => $this->__('Validated URL pattern'),
                'type'   => 'text',
                'index'  => 'url'
            ]
        );

        $this->addColumn('type',
            [
                'header' => $this->__('Type'),
                'type'   => 'text',
                'index'  => 'type'
            ]
        );

        $this->addColumn('name',
            [
                'header' => $this->__('Name'),
                'type'   => 'text',
                'index'  => 'name'
            ]
        );

        $this->addColumn('rule_content',
            [
                'header' => $this->__('Rule Content'),
                'type'   => 'text',
                'index'  => 'rule_content'
            ]
        );

        $this->addColumn('target',
            [
                'header' => $this->__('Target'),
                'type'   => 'text',
                'index'  => 'target'
            ]
        );

        $this->addColumn('preprocess',
            [
                'header' => $this->__('Preprocess'),
                'type'   => 'text',
                'index'  => 'preprocess',
            ]
        );

        $this->addColumn('patch_fix',
            [
                'header' => $this->__('Fixing Patch'),
                'type'   => 'text',
                'index'  => 'patch_fix'
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
     * @param Mageone_Qps_Model_Rule $row
     *
     * @return string
     */
    public function decorateStatus($value, $row)
    {
        if ($row->getEnabled()) {
            return '<span class="grid-severity-notice"><span>' . $value . '</span></span>';
        }

        return '<span class="grid-severity-critical"><span>' . $value . '</span></span>';
    }

}
