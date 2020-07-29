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
    const KEY_LENGTH = 32;
    const IV_LENGTH = 16;

    /**
     * @param string $message
     *
     * @return string
     */
    public function encryptMessage($message): string
    {
        $rij = new Rijndael();

        $symKey = Random::string(self::KEY_LENGTH);
        $iv     = Random::string($rij->getBlockLength() >> 3);

        $ciphertext = $this->encryptSymetrically($rij, $symKey, $iv, $message);
        $symKey     = $this->encryptAsymmetrically($symKey);

        return implode('|', array_map('base64_encode', [$iv, $symKey, $ciphertext]));
    }

    /**
     * @param string $message
     *
     * @return bool|int|string
     */
    public function decryptMessage($message)
    {
        $key = Mage::helper('qps')->getPublicKey();

        [$iv, $symKey, $message] = explode('|', $message);

        $symKey = $this->decryptAsymmetrically($key, $symKey);

        return $this->decryptSymmetrically($iv, $message, $symKey);
    }

    /**
     * @param Rijndael $rij
     * @param string   $symKey
     * @param string   $iv
     * @param string   $message
     *
     * @return false|string
     */
    private function encryptSymetrically(Rijndael $rij, $symKey, $iv, $message)
    {
        $rij->setKey($symKey);

        if ($rij->getBlockLength() >> 3 !== self::IV_LENGTH) {
            throw new RuntimeException('Update constant IV_LENGTH!');
        }

        $rij->setIV($iv);

        return $rij->encrypt($message);
    }

    /**
     * @param $symKey
     *
     * @return false|string
     */
    private function encryptAsymmetrically($symKey)
    {
        $rsa = new RSA();

        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey(Mage::helper('qps')->getPublicKey());
        $symKey = $rsa->encrypt($symKey);

        return $symKey;
    }

    /**
     * @param string $encoded
     *
     * @return string
     */
    private function decodeBase64AndCheck($encoded): string
    {
        $decoded = base64_decode($encoded, true);
        if (!$decoded) {
            throw new RuntimeException('base64_decode of IV failed');
        }

        return $decoded;
    }

    /**
     * @param string $key
     * @param string $symKey
     *
     * @return false|string
     */
    private function decryptAsymmetrically($key, $symKey)
    {
        $rsa = new RSA();
        // Decrypt the encrypted symmetric key
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($key);

        $symKey = $this->decodeBase64AndCheck($symKey);
        $symKey = $rsa->decrypt($symKey);

        return $symKey;
    }

    /**
     * @param string $iv
     * @param string $message
     * @param string $symKey
     *
     * @return false|int|string
     */
    private function decryptSymmetrically($iv, $message, $symKey)
    {
        $rij = new Rijndael();

        $iv = $this->decodeBase64AndCheck($iv);
        $rij->setIV($iv);

        $ciphertext = $this->decodeBase64AndCheck($message);

        $rij->setKey($symKey);

        return $rij->decrypt($ciphertext);
    }
}
