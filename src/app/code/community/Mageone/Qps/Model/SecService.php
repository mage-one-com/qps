<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'hpseclib/bootstrap.php');

/**
 * Class Mageone_Qps_Model_SecService
 */
class Mageone_Qps_Model_SecService
{
    const KEY_LENGTH = 150;

    /**
     * @param $payload
     * @param $key
     * @return string
     */
    function encryptMessage($payload, $key)
    {
        $rsa = new \phpseclib\Crypt\RSA();
        $rij = new \phpseclib\Crypt\Rijndael();


        // Generate Random Symmetric Key
        $symKey = \phpseclib\Crypt\Random::string(self::KEY_LENGTH);

        // Encrypt Message with new Symmetric Key
        $rij->setKey($symKey);
        $ciphertext = $rij->encrypt($payload);
        $ciphertext = base64_encode($ciphertext);

        // Encrypted the Symmetric Key with the Asymmetric Key
        $rsa->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);

        $rsa->loadKey($key);
        $symKey = $rsa->encrypt($symKey);

        // Base 64 encode the symmetric key for transport
        $symKey = base64_encode($symKey);
        $len = strlen($symKey); // Get the length
        $len = dechex($len); // The first 3 bytes of the message are the key length
        $len = str_pad($len, 3, '0', STR_PAD_LEFT); // Zero pad to be sure.
        // Concatenate the length, the encrypted symmetric key, and the message
        return $len . $symKey . $ciphertext;
    }

    /**
     * @param $message
     * @param $key
     * @return bool|int|string
     */
    function decryptMessage($message, $key)
    {
        $rsa = new \phpseclib\Crypt\RSA();
        $rij = new \phpseclib\Crypt\Rijndael();

        // Extract the Symmetric Key
        $len = substr($message, 0, 3);
        $len = hexdec($len);
        $symKey = substr($message, 3, $len);

        //Extract the encrypted message
        $message = substr($message, $len+3);
        $ciphertext = base64_decode($message);
        $ciphertext = str_replace(['\/', '\n'], ['/', ''], $ciphertext);
        // Decrypt the encrypted symmetric key
        $rsa->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($key);
        $symKey = base64_decode($symKey);
        $symKey = $rsa->decrypt($symKey);

        // Decrypt the message
        $rij->setKey($symKey);
        $plaintext = $rij->decrypt($ciphertext);

        return $plaintext;
    }
}