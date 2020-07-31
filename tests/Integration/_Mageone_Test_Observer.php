<?php

class Mageone_Test_Observer
{
    public static $called = 0;

    public function qpsCustomCheck(Varien_Event_Observer $observer): void
    {
        self::$called++;

        $obj = $observer->getData('transport_object');
        $obj->setData('passed', false);
    }
}
