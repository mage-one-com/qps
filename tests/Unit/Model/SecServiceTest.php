<?php

namespace MageOne\Qps\Test\Unit\Model;

use MageOne\Qps\Test\AbstractTest;

/**
 * @covers \Mageone_Qps_Model_SecService
 */
class SecServiceTest extends AbstractTest
{
    /**
     * @var \Mageone_Qps_Model_SecService
     */
    private $secService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->secService = \Mage::getModel('qps/secService');
    }

    public function testEncryptDecrypt()
    {
        for ($i = 0; $i <= 20; $i++) {
            $encryptedDecryptedMessage = $this->secService->decryptMessage(
                $this->secService->encryptMessage($this->getMessage())
            );
            $this->assertIsString(
                $encryptedDecryptedMessage,
                'I don\'t know why, but from time to time this test fails, therefore we run it 100 times, to make sure '
                . 'it fails on each run. We need to fix that.'
            );
            $this->assertEquals(
                $this->getMessage(),
                $encryptedDecryptedMessage
            );
        }
    }

    /**
     * @return string
     */
    private function getMessage()
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

    /**
     * @return string
     */
    private function getEncryptedMessage()
    {
        $encrypted
            = 'KtRiK+rhLwFZ4AxFHAPnBg==|i3ssMC4N/hEpc+TqCdNFMwExeeudncwWHz83I0oddWinA6vLAI4UoxiIrC2GbkhwSTkvQxuwLl'
            . 'u8gCXiWMMU4YsCz2ZuFfaaHRda4IHFeunPtgbUd6nbHdbpjO/q3ACO7VdYM/0APVunYCFaKvS6xyG0ko99OWYyUIJufRrcG+oiH'
            . 'w+LI4UUoj8zZRQAT6bihZKq2rqNDxVlGFMF+RreRw4VRFwARt7JT7D3mbbvWrQcqG8iDVJIab+NuIHfH4qURHLvxAOcCAkwUFAl'
            . 'Qyflhu3v9bwvbWSY2tbULS0sU7CpBScJY04UZhs5bfDAfk+h+ckAEnDZ3QE/96yOa7KVeg==|P3ZP/jC8eosZ8DzuzEb4+6Tg9f'
            . 'iwO56vfqXBJlbXjKMeRbvcDdKxMUcGJ4qnQipxz/jbupWiBNx7IKEHK0xBNBaVi9sqS3iNAr5czef0EIhkYq4BoK+O3OjqsB+aE'
            . 'l1808i4n+ObnfL97cp1E9f5pLMpcTwSWLlY31LJxSUTlpgO1+zOIgkygk1w4IFCv3lkyitVkZQerN7YW+eShK+9y2m1orVUmEwI'
            . 'Yn6+iy0SwL1fCIF++KjUwk2zKlSwkuOLegqHCNujXg9k6xzeJy877Cnr9UHHe+T2TtWQuVcHmhLw1WfvCslP7/FTzc6N930PB9d'
            . '5a0Dg+tdrs3evdI4TtDPIFPXzYlv1zGoh7jN4z0fV7N021DnvQKDDA+VMKLm0lsr/MV8bZhQ8A395Lu7MYw0yoctuvpKFIY5Co3'
            . '279p+MkuHz/juj/QRx71lzNM5/Iw1+ygvWpt8v2cjvrH2mhdEoQcB4zFsFKiJebN8e6cW3B5R3OXdpSKK8i553xCHoA1pi6cLzR'
            . 'QGeiOWXFxdv1P2USYNSEkkKit8VdmgtLkUGM7YNL7kEW4pg1PmGSQbxT+Hi2xIkTfghuxHAaH1dNiB1Pak19DI8DmQxV2k4jz3b'
            . 'xbXD0WGb4Xes+Nyj8Ejy2gdCf2WXsSZ3tkE7v3DX4ptiXqqSrFg1a/aQ9XnTHp7ZZIQ5xpYy8BnZfaoN+eY9OH6v0nQHlkCV1bS'
            . 'tfL37f4wstgnIwDmPrGtyD3a2a/SWOOuEgVAs+ala/Pv2BzVjyafRpcmdFZ8YdsfcxoIQcmfiWNJxJyXrPNItvD2Yqj34g00Nbt'
            . '9lWX4IjWzcZVoF4rKR0rcM8Td5rdB22GlyLHgqbJPf7hATsZp4PvP9zOIEW/oLKncHD+vbqpq+LVpNpIferg930pBsJAhxwOXBY'
            . '93BkWIrp5Q88Lun3d7B8G2OUmKf+h/MJ0ZuACBsakmXn4Ou6EUHATVOm7AfUFjEidVemLR0Z5YnxHH7GhpkF6MynYC15SqS5v6S'
            . 'FLaUW3QXodHuM3LXZU79VUOoxNCXKIfBLRtQ57xrdUtlPFUhRn2NPVGNRx9GK0w4WaH2cRsyYZ/ZRA3NBVtqqyBlOwF1fEoLghU'
            . 'QsDt3rKqc8AcBBi9JnTgE71MaOURAXwzx1H6RVzP2FonpzWTlfS7elNEtnNQpItm25qTam1BWo3Ij04oyZY2NEOG7W+d8isTLNv'
            . 'Tjuv772l40eWEHTHfde6u9QkUXJhu1wA5BvgGwnsToxLO5fFd0wubhw3hn7jP49UJ4CpTWn+SXBhSdcM5yYw6Seynd8qFCkLPGa'
            . '7js92vCTU8eIBaul+7Op+kVouribdfczD/FOYVJCkJafKC4FlXSfpEACS2fyAUeeJNOL4S0HffdqeVkx9Q08UZMp3S5NdvqYmaN'
            . 'QmrEF9UVCSL9b48Qlt+PhWX/hvKBw20W8BSk1qeMlTE4QVmGnuuYqmUS8N7M58q/UtCoYuMwScGQr1QJhiR6m7rGb+UBPLX53vx'
            . 'D6diWKfjrCq2rZ4qbVEUaHP7nwVZD1oqlOBj7GK9bxIEahKtTTKXAvT30Y/PRqvWJq6YAMtpSVGrjcpew2zP79uW7laX2nT3mf7'
            . 'EuhQhLbBbPV1VfQtoEj21l5a1B7NXlrJfprGscLnHDJz3p3Fkjp1fLCsBcg86AMUE7j3ZCKclWbaOsuVTDJ6cmp6J5NX1Fuc3AW'
            . 'ZSqi9hl9uAFMOc2E613ouDvki51wpXCsG+5ihndqh4NeoOJHR/cuvVTVYql+GmvrBVwL1WDy8ZRzrYGzi13AWfXUR6rwRGjpv1I'
            . 'dEb4C0KxcTAj/hwLXyMesyCMiim3IZrQUUWVgIxyKrtx1RjjkGIzFoPTUHl49x9/k70XGa03kwHZfy4Opd4FITAMRzGyZt2eLOm'
            . 'inEMwBRsDRseXZ/altWZmHbvlgDp2jeT0KIddVbzXuuyq/wi/tMQIa0rgDCdAFiAPdTuC7JDKvH5V52g47bYknHFr3ItzhSe4/9'
            . 'ldIXIVuqyBf1pfDYBG4+eiiqLGZmBZ9NAzmLl/P1taOSGGUEl6CZZnnXpWNPfkAdY+vxDyh6SXxxqLKnSddbyIL3YC47iKYZ5pP'
            . '7ipkwD03BikFQL5z2XQXzn02JBWqn61zYGk9019HORV/+tsHo3qqQjEvKyIhwy3418XGHA07d2BLLAl7bLjykqqgQ0CadcRRN35'
            . '938SZNNhtIgE5w6Sa9Ucy8IvS/zkCk9Gjdul/2BzazAxFgvFgbJoIaBEu9Nb2ekROGm3WW05jtRhghRSxN3BjxAMVptG/+s7V49'
            . 'EiTkLp2rqZbllvHGfRuGPax/MHxY94yjsJrEZe0ZkTU2sCrawrhNQZRLxPiW1kxl9elYPSJCy1YRWD1IGAdwSJXmlSA5yGo/Atd'
            . 'kvE96ePJtVndBeHp2gW8O0+Acl6qSQFAMACt0Y4AGae68R7dPq0L9V/95HGvtzM11lOQNcK8Z3kLGHTDI6euBBfNFc9NBQ72wzs'
            . 'WQNeTkpgzWHc4aWjkdDBjobY7z2FgEVrvImdpYBNHn+aATJNLdP7c2NMtHTOF8nsZG6A4U9p5F2sjZld+fOz4Z/xokC+PiTArGh'
            . '2+dNq8hTb8ZHO9fVd0NPisjhs1CkfyOlgdfJvlF2CcY5NWFaAEVsWYK/99yAoDEJZewRJmNLYuSEBs0+b8cR8lXCDDd2rGYZ9kT'
            . 'xhhf4b+6bciC0+NWcrCNLLqTHfnDPMeRm3HJxrTq6dZPPrRVB9ADJ9SDVJdJtUXGVnsqU//Esd33wRqB5zmxnKpyTuitEokKGUu'
            . 'cEs2a5clPlccHLDwkMs61m4KqaWsbRkuabulmYweL+GNZENd/SO9h2I0EWULVklay1H/kz9NDRG9m1rz9N9ZTiSof2IqOUPDDcO'
            . '96AVj+agdlx0rQ2VcrvBIJl9DAilybxjaG0EcXt7yVFQGc5';

        return base64_decode($encrypted, true);
    }
}
