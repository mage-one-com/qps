<?php

namespace MageOne\Qps\Test\Unit;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers Mageone_Qps_Model_Cron
 */
class CronTest extends AbstractTest
{
    public function testCron()
    {
        $this->assertInstanceOf(\Mageone_Qps_Model_Cron::class, \Mage::getModel('qps/cron'));
    }
}
