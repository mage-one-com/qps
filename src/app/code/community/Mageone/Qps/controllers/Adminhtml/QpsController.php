<?php

class Mageone_Qps_Adminhtml_QpsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('qps/rule'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('qps/rule');

        if (!$id) {
            $this->_getSession()->addError('You can\'t create new rules, only edit existing ones.');

            return $this->_redirect('*/*/index');
        }

        $model->load($id);
        if (!$model->getId()) {
            $this->_getSession()->addError(
                Mage::helper('qps')->__('This Rule no longer exists.')
            );
            $this->_redirect('*/*/');

            return;
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_model', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('qps/rule_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {

            $id    = $this->getRequest()->getParam('id');
            $model = Mage::getModel('qps/rule');
            if (!$id) {
                $this->_getSession()->addError('You can\'t create new rules, only edit existing ones.');

                return $this->_redirect('*/*/index');
            }

            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('qps')->__('This Rule no longer exists.')
                );
                $this->_redirect('*/*/index');

                return;
            }

            // save model
            try {
                $model->setData('enabled', $data['enabled']);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('qps')->__('The Rule has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('qps')->__('Unable to save the Rule.'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);

                return;
            }
        }
        $this->_redirect('*/*/index');
    }
}
