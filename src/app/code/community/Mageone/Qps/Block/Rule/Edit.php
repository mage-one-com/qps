<?php

declare(strict_types=1);

class Mageone_Qps_Block_Rule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup = 'qps';
        $this->_controller = 'rule';
        $this->_mode       = 'edit';
        $modelTitle        = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', [
            'label'   => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ], -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        $this->removeButton('delete');
    }

    protected function _getHelper()
    {
        return Mage::helper('qps');
    }

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getModelTitle()
    {
        return 'Rule';
    }

    public function getHeaderText()
    {
        $model      = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle (ID: %s)", $model->getId());
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    /**
     * Get form save URL
     *
     * @return string
     * @see getFormActionUrl()
     * @deprecated
     */
    public function getSaveUrl()
    {
        $this->setData('form_action_url', 'save');

        return $this->getFormActionUrl();
    }

}
