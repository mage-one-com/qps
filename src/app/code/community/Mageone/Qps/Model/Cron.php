<?php

class Mageone_Qps_Model_Cron
{

    public function getRules()
    {
        if (!Mage::helper("qps")->isEnabled()) {
            return null;
        }
        try {
            $client = $this->getClient();
            $client->setCredentials(Mage::helper('qps')->getUserName(), Mage::helper('qps')->getUserPass());
            $client->post(Mage::helper('qps')->getResourceUrl(),
                array('magento_vesrsion' => Mage::getVersion(),
                    'patches_list' => $this->getPatchList())
            );
            if ($client->getStatus() != 200) {
                Mage::log('Something went wrong while trying to update security rules, response: ' . $client->getStatus(), Zend_Log::ERR);
                return null;
            }
            $security = Mage::getModel('qps/SecService');
            $result = Mage::helper('core')->jsonDecode($security->decryptMessage($client->getBody(), Mage::helper("qps")->getPrivateKey()));
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
        $file = Mage::getBaseDir('etc') . '/applied.patches.list';
        try {
            $io = new Varien_Io_File();
            if ($io->fileExists($file)) {
                $content = $io->open(array('path' => Mage::getBaseDir('etc')));
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