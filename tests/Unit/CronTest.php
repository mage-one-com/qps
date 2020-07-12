<?php

namespace MageOne\Qps\Test\Unit;

use PHPUnit\Framework\TestCase;

/**
 * @covers Mageone_Qps_Model_Cron
 */
class CronTest extends TestCase
{
    public function testCron()
    {
        $this->assertInstanceOf(\Mageone_Qps_Model_Cron::class, \Mage::getModel('qps/cron'));
    }
}
