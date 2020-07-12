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

    public function __construct(array $args = [])
    {
        if (isset($args['client'])) {
            $this->client = $args['client'];
        }
        $this->helper = Mage::helper('qps');
    }

    /**
     * @return void
     */
    public function getRules()
    {
        if (!$this->helper->isEnabled()) {
            return;
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
            $client->post($this->helper->getResourceUrl(),
                [
                    'user'    => $this->helper->getUserName(),
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

                return;
            }

            $result = Mage::helper('core')->jsonDecode($security->decryptMessage($client->getBody()));
            if (!empty($result) && is_array($result)) {
                $resource   = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $connection->truncateTable($resource->getTableName('qps/rule'));
                /** @var array $item */
                foreach ($result as $item) {
                    Mage::getModel('qps/rule')->addData($item)->save();
                }
                Mage::app()->cleanCache([Mageone_Qps_Model_Observer::QPS_CACHE_TAG]);
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
        return $this->client ?: Mage_HTTP_Client::getInstance();
    }

    /**
     * @return string
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
