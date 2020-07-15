<?php

class Mageone_Qps_Block_Rule_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model      = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form       = new Varien_Data_Form([
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post'
        ]);

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => $this->_getHelper()->__("$modelTitle Information"),
            'class'  => 'fieldset-wide',
        ]);

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', [
                'name' => $modelPk,
            ]);
        }

        $fieldset->addField('enabled', 'select', [
            'name'   => 'enabled',
            'label'  => $this->_getHelper()->__('Status'),
            'values' => [0 => $this->__('Disabled'), 1 => $this->__('Enabled')],
            'note'   => $this->__('You can only enable and disable a rule.'),

        ]);

        $fieldset->addField('m1_key', 'text', [
            'name'     => 'm1_key',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Identifier'),
        ]);

        $fieldset->addField('url', 'text', [
            'name'     => 'url',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Validated URL pattern'),
        ]);

        $fieldset->addField('type', 'text', [
            'name'     => 'type',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Type'),
        ]);

        $fieldset->addField('name', 'text', [
            'name'     => 'name',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Name'),
        ]);

        $fieldset->addField('rule_content', 'text', [
            'name'     => 'rule_content',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Rule Content'),
        ]);

        $fieldset->addField('target', 'text', [
            'name'     => 'target',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Target'),
        ]);

        $fieldset->addField('preprocess', 'text', [
            'name'     => 'preprocess',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Preprocess'),
        ]);

        $fieldset->addField('patch_fix', 'text', [
            'name'     => 'patch_fix',
            'readonly' => true,
            'disabled' => true,
            'label'    => $this->_getHelper()->__('Fixing Patch'),
        ]);

        if ($model) {
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getModelTitle()
    {
        return 'Rule';
    }

    protected function _getHelper()
    {
        return Mage::helper('qps');
    }

}
