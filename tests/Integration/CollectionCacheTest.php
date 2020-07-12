<?php

namespace MageOne\Qps\Test\Integration;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers Mageone_Qps_Model_Resource_Rule_Collection
 */
class CollectionCacheTest extends AbstractTest
{
    public function testCachingIsUsed()
    {
        $this->assertTrue(
            \Mage::app()->useCache('collections'),
            'Collection cache needs to be enabled to run this test.'
        );

        \Mage::getResourceModel('qps/rule_collection')->load();
        /** @var \Mageone_Qps_Model_Resource_Rule_Collection $collection */
        $collection = \Mage::getResourceModel('qps/rule_collection')->load();

        $refMethod = new \ReflectionMethod($collection, '_loadCache');
        $refMethod->setAccessible(true);
        $cache = $refMethod->invoke($collection, $collection->getSelect());

        $this->assertNotEmpty($cache);
    }
}
