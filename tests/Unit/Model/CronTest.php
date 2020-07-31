<?php

namespace MageOne\Qps\Test\Unit\Model;

use Mage;
use MageOne\Qps\Test\AbstractTest;
use Mageone_Qps_Model_Cron;

/**
 * @covers Mageone_Qps_Model_Cron
 */
class CronTest extends AbstractTest
{
    public function testCron(): void
    {
        $this->assertInstanceOf(Mageone_Qps_Model_Cron::class, Mage::getModel('qps/cron'));
    }
}
