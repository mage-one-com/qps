<?php

namespace MageOne\Qps\Test;

use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    /**
     * @var string[]
     */
    private $configSettingsToRestore;

    public const EXAMPLE_USER = 'example@mage-one.com';

    /**
     * @param string   $path
     * @param string   $value
     * @param int|null $storeId
     */
    public function setConfigurationSetting($path, $value, $storeId = null)
    {
        $storeIds = $storeId ? [$storeId] : array_keys(\Mage::app()->getStores());
        foreach ($storeIds as $storeId) {
            $store   = \Mage::app()->getStore($storeId);
            $storeId = $storeId === null ? 0 : $storeId;

            $this->configSettingsToRestore[$storeId][$path] = $store->getConfig($path);

            $this->setConfig($path, $value, $store);

        }
    }

    /**
     * @param string                      $path
     * @param string                      $value
     * @param \Mage_Core_Model_Store|null $store
     */
    private function setConfig($path, $value, \Mage_Core_Model_Store $store = null)
    {
        $propReflection = new \ReflectionProperty(\Mage_Core_Model_Store::class, '_configCache');
        $propReflection->setAccessible(true);
        $settings        = $propReflection->getValue($store);
        $settings[$path] = $value;
        $propReflection->setValue($store, $settings);
        $propReflection->setAccessible(false);
    }

    protected function setUp(): void
    {
        $this->startTransaction();

        parent::setUp();
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_STATUS, 1);
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_USER, self::EXAMPLE_USER);
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_PRIVATE_KEY, $this->getPrivateKey());
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_PUBLIC_KEY, $this->getPublicKey());
    }

    protected function tearDown(): void
    {
        $this->restoreConfigSettings();
        parent::tearDown();
        $this->rollbackTransaction();

    }

    private function restoreConfigSettings()
    {
        foreach ($this->configSettingsToRestore as $storeId => $settings) {
            $store = \Mage::app()->getStore($storeId);
            foreach ($settings as $path => $value) {
                $this->setConfig($path, $value, $store);
            }
        }
    }

    /**
     * @return string
     */
    private function getPrivateKey()
    {
        return '-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAuCW8CyWqeDXW6E93D+u5Tlq7Ys0mpLfQUbBdEivwPHKgWwYg
b4OA6vTqYObb7OqXUDU/lznCSGvhD+CbQMxyC0603/LO2y7/cGBQHODBh8EKpzd2
E0QUoO7Y9+JKcrsSwIqgULxRbMqcIfdXFaZSIjHU3OcOXgfb8DhWZi09FcJs8mjD
QNHPP+6PwK/uFue3YYyN8SUUU2ot0oielMCsML4JY0Nrj0jZkLlkufZdxMF8zLF2
1AwP/sX8imSkaj4895EnqJ6cpEaTOgj2UlcFoypW5qu4Pe2F4QBEl4E2o8ltmqsn
3EphqzrEphd4FSt8f2CbSztLQ046asfCcRDoLQIDAQABAoIBAEUTop5r2q6NQ7iR
VpBaVIDX+ELvwfc4HKUIC2GtqciDFzQN8Ezkf4+jn+gJsaYFug0UbG5F9GNGVH6o
OpTsHDuxopf/dSkzUA7Pkj3C8dYCzAQ+AcToXPShpDIYaOTw1+/yEIE4ozK0Li1v
ovM0GMtK9haHdhQ/znkmKQLbJXbrfKgz5J1v9IJ8+k1WmjUrLumFPvCEcBoBvaIV
ygsBBS/Sum96lVvYC9SjtGJcE+RN3DP7yXeJdgjr564GTZO7PEtWjGe2kbsNkCd/
vJQy2gRzFQ1nk8TnYr8x6vOQKCUUSelvucaIYXsOIuicpCV5FD3ePjx9VBIBFiG6
KL/lzwECgYEA6g+IC6oKQgcZytwJAd5sZuk0BxVQk2IibgDQXpt5s/PRJVYRWH45
TzTRrZRgN8MFWDTAG0RSKAuw0vrBlDOaPu/29xV/Es78gKbNt6cR158iOo7CQepN
rw1ADHd7zMhHpj1/9izDu+BMITTJAxjWS29HitEhVzgZHZmZLMEATXUCgYEAyWh+
yDyC4xXTuDTd04XRKRm//QKdmTNn/hepS4uH8lCA0bOBf4w23Uh/57wIYSZ0aTf5
YbEEqDIKvijGWQB7q/zo1V9b654l4l8VNvbAaIEFbeUmrhhcXWGn9GxhbaKQCN3G
xtJoqEGQcLjfBuqIvYczLgWve2xfQ5vHl6pqQNkCgYEA5x0+8IWOa3Qne6+ZFUdT
MqrCvNvHHECiToxvM3vByHbP5VX++qpoXFWDVSpVd7oR5O7xYfssRG6Gw0znKDdr
7wlziranKyNHIKGUL+vAKnDvk3KzTfLVkiw7OhQhIiwA052WZLX+79yiT4eXlH9J
2mKe+etWSJET+65XGWHZsqECgYEAkNyAu8KSHYTYd9hGaFoKO3aS2Qallcgcluwr
zvM3v3hZfvqOPM/7siLwJBvhJwcCmZ8x1ir8/4Cmq2kmaGNpkCVizf09XvWrp+rd
ll/ZuhB6eDVmIbfRzzRrGelOFg3jbQ0eaGhz7/jgS8McXpwX58GzdPmP4sTqq/UC
lLp0m9kCgYEAmhOvUdyfvSdTM+EQNpF/+nQxIIeoJ8fQICayKzfTt/JxoZagnQ2L
ttN9LdCCHb6T79AHfi5n6Wjl4xvtYoQ3chpLFoy7fXuLgUtGxDiK7KQQMdCg9bb7
3wj6lTv0HrUnekjMhrAwa/LUx0eahM8w8vRG9K4xUX5nX2bV0cbG8Cs=
-----END RSA PRIVATE KEY-----';
    }

    /**
     * @return string
     */
    private function getPublicKey()
    {
        return '-----BEGIN RSA PUBLIC KEY-----
MIIBCgKCAQEAuCW8CyWqeDXW6E93D+u5Tlq7Ys0mpLfQUbBdEivwPHKgWwYgb4OA
6vTqYObb7OqXUDU/lznCSGvhD+CbQMxyC0603/LO2y7/cGBQHODBh8EKpzd2E0QU
oO7Y9+JKcrsSwIqgULxRbMqcIfdXFaZSIjHU3OcOXgfb8DhWZi09FcJs8mjDQNHP
P+6PwK/uFue3YYyN8SUUU2ot0oielMCsML4JY0Nrj0jZkLlkufZdxMF8zLF21AwP
/sX8imSkaj4895EnqJ6cpEaTOgj2UlcFoypW5qu4Pe2F4QBEl4E2o8ltmqsn3Eph
qzrEphd4FSt8f2CbSztLQ046asfCcRDoLQIDAQAB
-----END RSA PUBLIC KEY-----';
    }

    protected function startTransaction()
    {
        $writeConnection = $this->getConnection();
        $writeConnection->beginTransaction();
    }

    protected function rollbackTransaction()
    {
        $writeConnection = $this->getConnection();
        $writeConnection->rollBack();
    }

    /**
     * @return \Varien_Db_Adapter_Interface
     */
    protected function getConnection()
    {
        return \Mage::getSingleton('core/resource')->getConnection('core_write');
    }
}
