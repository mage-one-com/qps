<?php

namespace MageOne\Qps\Test;

use PHPUnit\Framework\TestCase;

class AbstractTest extends TestCase
{
    private $configSettingsToRestore;

    /**
     * @param string   $path
     * @param string   $value
     * @param int|null $storeId
     */
    public function setConfigurationSetting($path, $value, $storeId = null)
    {
        $store   = \Mage::app()->getStore($storeId);
        $storeId = $storeId === null ? 0 : $storeId;

        $this->configSettingsToRestore[$storeId][$path] = $store->getConfig($path);

        $this->setConfig($path, $value, $store);
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

    protected function tearDown(): void
    {
        $this->restoreConfigSettings();
        parent::tearDown();
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
}
