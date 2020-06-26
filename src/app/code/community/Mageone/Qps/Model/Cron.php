<?php

class Mageone_Qps_Model_Cron
{

    public function getRules()
    {
        if (!Mage::helper('qps')->isEnabled()) {
            return null;
        }
        try {
            $security = Mage::getModel('qps/secService');
            $client   = $this->getClient();
            $message  = $security->encryptMessage(
                json_encode([
                    'magento_version' => Mage::getVersion(),
                    'patches_list'    => $this->getPatchList()
                ])
            );
            $client->post(Mage::helper('qps')->getResourceUrl(),
                [
                    'user'    => Mage::helper('qps')->getUserName(),
                    'message' => $message
                ]
            );
            if ($client->getStatus() !== 200) {
                Mage::log(
                    sprintf(
                        'Something went wrong while trying to update security rules, response: %s',
                        $client->getStatus()
                    ),
                    Zend_Log::ERR
                );

                return null;
            }

            $result = Mage::helper('core')->jsonDecode($security->decryptMessage($client->getBody()));
            if (!empty($result) && is_array($result)) {
                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $connection->truncateTable('mageone_qps_rules');
                /** @var array $item */
                foreach ($result as $item) {
                    Mage::getModel('qps/rule')->addData($item)->save();
                }
                Mage::app()->cleanCache([Mageone_Qps_Model_Observer::QPS_CACHE_TAG]);
            }
        } catch (Exception $exception) {
            Mage::logException($exception);
        }

        return;
    }

    /**
     * @return Mage_HTTP_IClient
     * @throws Exception
     */
    private function getClient()
    {
        return Mage_HTTP_Client::getInstance();
    }

    /**
     * @throws Exception
     */
    private function getPatchList()
    {
        $content = '';
        $file    = Mage::getBaseDir('etc') . '/applied.patches.list';
        try {
            $io = new Varien_Io_File();
            if ($io->fileExists($file)) {
                $io->open(['path' => Mage::getBaseDir('etc')]);
                $content = $io->read($file);
                preg_match_all('/ (SUPEE-\d*)\s\|/im', $content, $out, PREG_PATTERN_ORDER);
                if (isset($out[0])) {
                    $content = implode('', $out[0]);
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $content;
    }
}
