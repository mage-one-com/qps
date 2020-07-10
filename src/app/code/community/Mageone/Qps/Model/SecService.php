<?php

use phpseclib\Crypt\Random;
use phpseclib\Crypt\Rijndael;
use phpseclib\Crypt\RSA;

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib/bootstrap.php');

/**
 * Class Mageone_Qps_Model_SecService
 */
class Mageone_Qps_Model_SecService
{
    const KEY_LENGTH = 150;

    /**
     * @param string $message
     *
     * @return string
     */
    public function encryptMessage($message)
    {
        $key = Mage::helper('qps')->getPublicKey();

        $rsa = new RSA();
        $rij = new Rijndael();

        // Generate Random Symmetric Key
        $symKey = Random::string(self::KEY_LENGTH);

        // Encrypt Message with new Symmetric Key
        $rij->setKey($symKey);
        $ciphertext = $rij->encrypt($message);
        $ciphertext = base64_encode($ciphertext);

        // Encrypted the Symmetric Key with the Asymmetric Key
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);

        $rsa->loadKey($key);
        $symKey = $rsa->encrypt($symKey);

        // Base 64 encode the symmetric key for transport
        $symKey = base64_encode($symKey);
        $len    = strlen($symKey); // Get the length
        $len    = dechex($len); // The first 3 bytes of the message are the key length
        $len    = str_pad($len, 3, '0', STR_PAD_LEFT); // Zero pad to be sure.
        // Concatenate the length, the encrypted symmetric key, and the message
        return $len . $symKey . $ciphertext;
    }

    /**
     * @param string $message
     *
     * @return bool|int|string
     */
    public function decryptMessage($message)
    {
        $key = Mage::helper('qps')->getPrivateKey();

        $rsa = new RSA();
        $rij = new Rijndael();

        // Extract the Symmetric Key
        $len    = substr($message, 0, 3);
        $len    = hexdec($len);
        $symKey = substr($message, 3, $len);

        //Extract the encrypted message
        $message    = substr($message, $len + 3);
        $ciphertext = base64_decode($message);
        $ciphertext = str_replace(['\/', '\n'], ['/', ''], $ciphertext);
        // Decrypt the encrypted symmetric key
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($key);
        $symKey = base64_decode($symKey);
        $symKey = $rsa->decrypt($symKey);

        // Decrypt the message
        $rij->setKey($symKey);

        return $rij->decrypt($ciphertext);
    }
}
