<?php

namespace MageOne\Qps\Test;

use Mage;
use Mage_Core_Exception;
use Mage_Core_Model_Resource;
use Mage_Core_Model_Store;
use Mage_Core_Model_Store_Exception;
use MageOne_Qps_Helper_Data;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Varien_Db_Adapter_Interface;

abstract class AbstractTest extends TestCase
{
    public const EXAMPLE_USER = 'example@mage-one.com';
    /**
     * @var MageOne_Qps_Helper_Data|MockObject
     */
    protected $helperMock;
    /**
     * @var string[]
     */
    private $configSettingsToRestore;
    /**
     * @var string[]
     */
    private $cleanupHelperMocks;

    protected function setUp(): void
    {
        $this->startTransaction();

        parent::setUp();
        $this->setConfigurationSetting(MageOne_Qps_Helper_Data::QPS_STATUS, 1);
        $this->setConfigurationSetting(MageOne_Qps_Helper_Data::QPS_USER, self::EXAMPLE_USER);
        $this->setConfigurationSetting(MageOne_Qps_Helper_Data::QPS_PUBLIC_KEY, $this->getPublicKey());
        $this->setConfigurationSetting(MageOne_Qps_Helper_Data::QPS_RULE_AUTO_ENABLE, 1);

        $this->helperMock = $this->createMock(MageOne_Qps_Helper_Data::class);

        // returns one time the private and one time the public key to test decryption/encryption
        // for two rule testing this method is called three times and needs to return public key
        // TODO fix this weird setup
        $this->helperMock
            ->expects($this->atMost(4))
            ->method('getPublicKey')
            ->willReturnOnConsecutiveCalls(
                $this->getPrivateKey(),
                $this->getPublicKey(),
                $this->getPublicKey()
            );

        $this->helperMock->method('isEnabled')->willReturn(true);
        $this->replaceHelperWithMock($this->helperMock, 'qps');
    }

    protected function startTransaction(): void
    {
        $writeConnection = $this->getConnection();
        $writeConnection->beginTransaction();
    }

    /**
     * @return Varien_Db_Adapter_Interface
     */
    protected function getConnection(): Varien_Db_Adapter_Interface
    {
        return $this->getResource()->getConnection('core_write');
    }

    /**
     * @param string   $path
     * @param string   $value
     * @param int|null $singleStoreId
     *
     * @throws Mage_Core_Model_Store_Exception
     */
    public function setConfigurationSetting($path, $value, $singleStoreId = null): void
    {
        $storeIds = $singleStoreId ? [$singleStoreId] : array_keys(Mage::app()->getStores());
        foreach ($storeIds as $storeId) {
            $store   = Mage::app()->getStore($storeId);
            $storeId = $storeId === null ? 0 : $storeId;

            $this->configSettingsToRestore[$storeId][$path] = $store->getConfig($path);

            $this->setConfig($path, $value, $store);
        }
    }

    /**
     * @param string                     $path
     * @param string                     $value
     * @param Mage_Core_Model_Store|null $store
     */
    private function setConfig($path, $value, Mage_Core_Model_Store $store = null): void
    {
        $propReflection = new ReflectionProperty(Mage_Core_Model_Store::class, '_configCache');
        $propReflection->setAccessible(true);
        $settings        = $propReflection->getValue($store);
        $settings[$path] = $value;
        $propReflection->setValue($store, $settings);
        $propReflection->setAccessible(false);
    }

    /**
     * @return string
     */
    protected function getPublicKey(): string
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

    /**
     * @return string
     */
    protected function getPrivateKey(): string
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
     * @param object $mock
     * @param string $helper
     *
     * @throws Mage_Core_Exception
     */
    protected function replaceHelperWithMock($mock, $helper): void
    {
        Mage::unregister('_helper/' . $helper);
        Mage::register('_helper/' . $helper, $mock);
        $this->cleanupHelperMocks[$helper] = $helper;
    }

    protected function tearDown(): void
    {
        $this->restoreConfigSettings();
        parent::tearDown();
        $this->rollbackTransaction();

        foreach ($this->cleanupHelperMocks as $helper) {
            Mage::unregister('_helper/' . $helper);
        }

    }

    private function restoreConfigSettings(): void
    {
        foreach ($this->configSettingsToRestore as $storeId => $settings) {
            $store = Mage::app()->getStore($storeId);
            foreach ($settings as $path => $value) {
                $this->setConfig($path, $value, $store);
            }
        }
    }

    protected function rollbackTransaction(): void
    {
        $writeConnection = $this->getConnection();
        $writeConnection->rollBack();
    }

    /**
     * @return Mage_Core_Model_Resource
     */
    protected function getResource(): Mage_Core_Model_Resource
    {
        /** @var Mage_Core_Model_Resource $return */
        $return = Mage::getSingleton('core/resource');

        return $return;
    }
}
