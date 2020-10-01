<?php

declare(strict_types = 1);

class Mageone_Qps_Model_EmailService
{

    public function sendNotificationEmail(Mageone_Qps_Helper_Data $helper)
    {
        $variables = [];
        if (!$helper->isRuleAutoEnable()) {
            $variables['notautoenable'] = 'true';
        }

        $mail = Mage::getModel('core/email_template');
        $mail->sendTransactional(
            'mageone_qps_ruleupdate',
            'general',
            $helper->getNotifactionEmail(),
            'Mage One QPS',
            $variables
        );

    }
}
