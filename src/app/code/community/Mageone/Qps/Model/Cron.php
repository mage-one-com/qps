<?php

class Mageone_Qps_Model_Cron
{
    /**
     * @var Mage_HTTP_Client
     */
    private $client;
    /**
     * @var Mageone_Qps_Helper_Data
     */
    private $helper;
    /**
     * @var Mageone_Qps_Model_EmailService
     */
    private $emailService;

    public function __construct(array $args = [])
    {
        $this->client = Mage::getModel('qps/http_client_curl');
        if (isset($args['client'])) {
            $this->client = $args['client'];
        }
        $this->helper       = Mage::helper('qps');
        $this->emailService = Mage::getModel('qps/emailService');
    }

    /**
     * @return void
     */
    public function getRules(): void
    {
        if (!$this->helper->isEnabled()) {
            return;
        }
        try {
            $sendNotification = false;
            $security         = Mage::getModel('qps/secService');
            $client           = $this->getClient();
            $message          = $security->encryptMessage(
                json_encode(
                    [
                        'magento_version' => Mage::getVersion(),
                        'patches_list'    => $this->getPatchList(),
                    ])
            );
            $client->post(
                $this->helper->getResourceUrl(),
                [
                    'user'    => $this->helper->getUserName(),
                    'message' => $message,
                ]
            );
            if ($client->getStatus() >= 300) {
                Mage::log(
                    sprintf(
                        'Something went wrong while trying to update security rules, response: %s',
                        $client->getStatus()
                    ),
                    Zend_Log::ERR
                );

                return;
            }

            $result = json_decode($security->decryptMessage($client->getBody()), true);
            if (is_array($result)) {
                /** @var $keys string[] */
                // load all rules before update
                $collection = Mage::getResourceModel('qps/rule_collection');
                /** @var array $item */
                foreach ($result as $item) {
                    // update rules, save to database and unset on collection
                    $rule = $collection->getItemByColumnValue('m1_key', $item['m1_key']) ?: Mage::getModel('qps/rule');
                    if ($rule->isObjectNew()) {
                        $sendNotification = true;
                        $rule->setEnabled($this->helper->isRuleAutoEnable());
                    }
                    $rule->addData($item)->save();
                    $collection->removeItemByKey($rule->getId());
                }
                // delete everything which was not updated and unset
                $collection->walk('delete');
                Mage::app()->cleanCache([Mageone_Qps_Model_Observer::QPS_CACHE_TAG]);
                if ($sendNotification === true) {
                    $this->emailService->sendNotificationEmail($this->helper);
                }
            }
        } catch (Exception $exception) {
            Mage::logException($exception);
        }
    }

    /**
     * @return Mage_HTTP_IClient
     * @throws Exception
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * @return string[]
     * @throws Exception
     */
    private function getPatchList(): array
    {
        return Mage::helper('qps/patches')->getPatchList();
    }
}
