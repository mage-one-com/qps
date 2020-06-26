<?php

/** @var $this Mage_Core_Model_Resource_Setup */

require Mage::getBaseDir() . '/lib/phpseclib/bootstrap.php';
require Mage::getBaseDir() . '/lib/phpseclib/Crypt/RSA.php';

$rsa = new \phpseclib\Crypt\RSA();

$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

define('CRYPT_RSA_EXPONENT', 65537);
define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
$keys = $rsa->createKey(2048); // == $rsa->createKey(1024) where 1024 is the key size

$this->setConfigData(\Mageone_Qps_Helper_Data::QPS_PRIVATE_KEY, $keys['privatekey']);
$this->setConfigData(\Mageone_Qps_Helper_Data::QPS_PUBLIC_KEY, $keys['publickey']);
