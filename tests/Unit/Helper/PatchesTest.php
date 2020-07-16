<?php

namespace MageOne\Qps\Test\Unit\Helper;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers Mageone_Qps_Helper_Patches
 */
class PatchesTest extends AbstractTest
{
    /**
     * @var \Mageone_Qps_Helper_Patches
     */
    private $helper;
    /**
     * @var string[]
     */
    private $deleteFiles = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = \Mage::helper('qps/patches');
    }

    protected function tearDown(): void
    {
        foreach ($this->deleteFiles as $file) {
            unlink($file);
        }
        $this->clearConfigCache();
        \Mage::getConfig()->reinit();
        parent::tearDown();
    }

    public function testGetPatchList()
    {
        $this->assertSame(['test-patch' => 'TEST patch'], $this->helper->getPatchList());
    }

    public function testGetPatchListWithNewXml()
    {
        $filePatch           = \Mage::getBaseDir('etc') . '/' . 'mageone1.xml';
        $this->deleteFiles[] = $filePatch;

        $xmlConfig = <<<XML
<?xml version="1.0"?>
<config>
    <mage-one>
        <patches>
            <patch2>PATCH TWO</patch2>
        </patches>
    </mage-one>
</config>
XML;
        file_put_contents($filePatch, $xmlConfig);
        \Mage::getConfig()->reinit();
        $this->assertSame(['patch2' => 'PATCH TWO', 'test-patch' => 'TEST patch'], $this->helper->getPatchList());
    }

    /**
     * @return mixed
     */
    private function clearConfigCache()
    {
        \Mage::getConfig()->loadCache();

        return \Mage::app()->getCacheInstance()->cleanType('config');
    }
}
