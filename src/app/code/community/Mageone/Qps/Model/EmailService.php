<?php

declare(strict_types = 1);

class Mageone_Qps_Model_EmailService
{

    public function sendNotificationEmail(Mageone_Qps_Helper_Data $helper)
    {
        if ($helper->isNotificationEnabled() === false ) {
            return;
        }

        if(!$this->isEmailValid($helper->getNotifactionEmail())){
            Mage::log('QPS notification email address seems to be invalid. Please check your configuration!');
            return;
        }
        
        $variables = [];
        if (!$helper->isRuleAutoEnable()) {
            $variables['notautoenable'] = 'true';
        }

        $mail = Mage::getModel('core/email_template');
        try {
            $mail->sendTransactional(
                'mageone_qps_ruleupdate',
                'general',
                $helper->getNotifactionEmail(),
                'Mage One QPS',
                $variables
            );
        } catch (Mage_Core_Exception $e) {
            Mage::log('QPS notification email could not be send.');
        }
    }

    private function isEmailValid($emailAddress)
    {
        return filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
    }
}
