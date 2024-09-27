<?php

namespace MageOne\Qps\Test\Integration;

use Mage;
use MageOne\Qps\Test\AbstractTest;
use MageOne_Qps_Model_Resource_Rule_Collection;
use ReflectionMethod;

/**
 * @covers MageOne_Qps_Model_Resource_Rule_Collection
 */
class CollectionCacheTest extends AbstractTest
{
    public function testCachingIsUsed(): void
    {
        $this->assertTrue(
            Mage::app()->useCache('collections'),
            'Collection cache needs to be enabled to run this test.'
        );

        Mage::getResourceModel('qps/rule_collection')->load();
        /** @var MageOne_Qps_Model_Resource_Rule_Collection $collection */
        $collection = Mage::getResourceModel('qps/rule_collection')->load();

        $refMethod = new ReflectionMethod($collection, '_loadCache');
        $refMethod->setAccessible(true);
        $cache = $refMethod->invoke($collection, $collection->getSelect());

        $this->assertNotEmpty($cache);
    }
}
