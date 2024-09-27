<?php

namespace MageOne\Qps\Test\Unit\Model;

use Mage;
use MageOne\Qps\Test\AbstractTest;
use MageOne_Qps_Model_SecService;

/**
 * @covers \MageOne_Qps_Model_SecService
 */
class SecServiceTest extends AbstractTest
{
    /**
     * @var MageOne_Qps_Model_SecService
     */
    private $secService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->secService = Mage::getModel('qps/secService');
    }

    public function testEncryptDecrypt(): void
    {

        $encryptedDecryptedMessage = $this->secService->decryptMessage(
            $this->secService->encryptMessage($this->getMessage())
        );
        $this->assertIsString(
            $encryptedDecryptedMessage,
            'Something went wrong on decryption.'
        );
        $this->assertEquals(
            $this->getMessage(),
            $encryptedDecryptedMessage
        );
    }

    /**
     * @return string
     */
    private function getMessage(): string
    {
        return 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut lab'
            . 'ore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et e'
            . 'a rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsu'
            . 'm dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dol'
            . 'ore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. S'
            . 'tet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor si'
            . 't amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna '
            . 'aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita '
            . 'kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. ' . "\n\n"
            . 'Duis autem vel eum iriure do'
            . 'lor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilis'
            . 'is at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue '
            . 'duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed d'
            . 'iam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. ' . "\n\n"
            . 'Ut wisi enim ad mi'
            . 'nim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo con'
            . 'sequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel i'
            . 'llum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit pr'
            . 'aesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. ' . "\n\n"
            . 'Nam liber tempor cum solu'
            . 'ta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lore'
            . 'm ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laore'
            . 'et dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamc'
            . 'orper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ' . "\n\n"
            . 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum ';
    }
}
