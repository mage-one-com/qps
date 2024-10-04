<?php

namespace MageOne\Qps\Test\Unit\Model;

use Mage;
use MageOne\Qps\Test\AbstractTest;
use MageOne_Qps_Model_Cron;

/**
 * @covers MageOne_Qps_Model_Cron
 */
class CronTest extends AbstractTest
{
    public function testCron(): void
    {
        $this->assertInstanceOf(MageOne_Qps_Model_Cron::class, Mage::getModel('qps/cron'));
    }
}
