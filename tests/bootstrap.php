<?php

chdir(__DIR__ . '/../../../');

error_reporting(E_ALL ^ E_DEPRECATED);

require 'AbstractTest.php';

require 'app/Mage.php';
Mage::app();
