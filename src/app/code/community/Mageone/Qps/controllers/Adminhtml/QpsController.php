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
            $this->_getSession()->addError('You can\'t create new rules. You can only change the status of existing rules.');

            return $this->_redirect('*/*/index');
        }

        $model->load($id);
        if (!$model->getId()) {
            $this->_getSession()->addError(
                Mage::helper('qps')->__('This Rule no longer exists.')
            );

            return $this->_redirect('*/*/');
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

            $id      = $this->getRequest()->getParam('id');
            $model   = Mage::getModel('qps/rule');
            $session = $this->_getSession();
            if (!$id) {
                $session->addError('You can\'t create new rules. You can only change the status of existing rules.');

                return $this->_redirect('*/*/index');
            }

            $model->load($id);
            if (!$model->getId()) {
                $session->addError(
                    Mage::helper('qps')->__('This rule no longer exists.')
                );

                return $this->_redirect('*/*/index');
            }

            // save model
            try {
                $model->setData('enabled', $data['enabled']);
                $session->setFormData($data);
                $model->save();
                $session->setFormData(false);
                $session->addSuccess(
                    Mage::helper('qps')->__('The rule has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $session->addError(Mage::helper('qps')->__('Unable to save this rule.'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                return $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            }
        }
        $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/qps_section');
    }
}
