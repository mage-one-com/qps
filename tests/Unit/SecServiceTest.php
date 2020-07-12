<?php

namespace MageOne\Qps\Test\Unit;

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

    //    public function testEncrypt()
    //    {
    //        // We can\'t test encryption against a fixture, because the symmetric key is
    //        // random. But we test encryption/decryption and this should work.
    //
    //        //        $this->assertEquals(
    //        //            $this->getEncryptedMessage(),
    //        //            $this->secService->encryptMessage($this->getMessage())
    //        //        );
    //    }

    public function testDecrypt()
    {
        $this->assertEquals(
            $this->getMessage(),
            $this->secService->decryptMessage($this->getEncryptedMessage())
        );
    }

    public function testEncryptDecrypt()
    {
        for ($i = 0; $i <= 100; $i++) {
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
            . 'Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum '
            . 'dolore eu feugiat nulla facilisis. ' . "\n\n"
            . 'At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata san'
            . 'ctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam'
            . ' nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos'
            . ' et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est L'
            . 'orem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquya'
            . 'm diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet '
            . 'clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum'
            . ' dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempo'
            . 'r invidunt ut labore et dolore magna aliquyam erat. ' . "\n\n"
            . 'Consetetur sadipscing elitr, sed diam nonumy eir'
            . 'mod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam'
            . ' et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum '
            . 'dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor'
            . ' invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo '
            . 'duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit '
            . 'amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt '
            . 'ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolore'
            . 's et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus. ' . "\n\n"
            . 'Lorem ipsum dolor sit amet, conse'
            . 'tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat'
            . ', sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergre'
            . 'n, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadi'
            . 'pscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam'
            . ' voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea '
            . 'takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing eli'
            . 'tr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.'
            . ' At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata s'
            . 'anctus est Lorem ipsum dolor sit amet. ' . "\n\n"
            . 'Duis autem vel eum iriure dolor in hendrerit in vulputate vel'
            . 'it esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iu'
            . 'sto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla faci'
            . 'lisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidun'
            . 't ut laoreet dolore magna aliquam erat volutpat. ' . "\n\n"
            . 'Ut wisi enim ad minim veniam, quis nostrud exerci t'
            . 'ation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure'
            . ' dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla faci'
            . 'lisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit aug'
            . 'ue duis dolore te feugait nulla facilisi. ';
    }

    /**
     * @return string
     */
    private function getEncryptedMessage()
    {
        $encrypted = 'MTU4UngwNGNhVzd0bkNjamoyT1MzNThkY3ZmY2padHBibGpTUVdhcUw0RmhXRFIwOGNuQ3Nlc2dxQUt1T0IyUGdNMjlOTWx'
            . 'jU3JoQ0dOelErcm5JcWU1bVp0Tzc4TE9RR2JFaUU2QmgrVm1TUSt5eHFvWHRaQjlvak12c2kxeHRqbGlHeFM4Qi9HR3B5TVk4NXg5T'
            . 'ElaOVIyd2d5bUIwOThEUFNJTHZFcnU2K0hPcjAvdFFuemNwM1lFN2tCWmVkTS9HWW1pOHdGZUtpYjloZFdDOW5jTmdteTZSMWJwMHB'
            . '2b2tKMkpQVFpPVE5KekhPV3FUazQyalBKWTVuSmVDTHN6T0Nyc2tlNFd1eHViQkkrdFlaTmlWWVVRYTFqaVphQzRyanZPVytsWG1Od'
            . 'mMwRkZCdHhTWHlocUZYbWFraTk0Q0xWQ2FZa0dNeDZZQ0phb1hvanlTN1hRPT1LV1I5cE00cU16N252bjJkTWFoS0Z1UmZXQWhJbDd'
            . 'CYjNsMHlDUmlBb2YwQ0FoNjBjcHpFN2NZbTIzMFFTWjlUVk12UnU3bDI2VFFXUTg3T0hwTElJN0xvL29CTWJoRnNIai9Qak5iQnJNd'
            . 'VNQcUxJZVdpNzBpT0tHcUZDL1YvblJ4WCtUaXpyZEV3eXluUGxyNzlsbkpOS2NjbzVLd3dnZ2hmRzdlL1ByMDgvRVpuc1dTTU1pVDd'
            . 'xY2NZNWEyV2VVdFFjMFIwYkwzbXZlblc0M0JnNnk3TmtWbElMdDVKTWRiWFd2S0RDUGRDSWJ5SzZTWTU0Z3ppZnMzclNMNzd3UjRzZ'
            . 'VJaYXhLSDU3U1M0TEw4R1ZoWVdoSXJXVlBJMTUvL2Q4UDFlbHN1S096WitHVjJzN3EvVUlFNkRvZGlNSVdoQVBJOTgxMi9veGRKU2k'
            . '1djRxTzlpOFdVYXlkZHdadXB6Ui9wL2V4NnFCemNZbTI5K0YyRFdkRzVwOFc5QjNqdjRyQmhtdElRbHBHNEEwOUdRYXNRaGw1ZWE0N'
            . 'jh4TkR0WDVHVUc2dzNySUNRNnBDTmM4OVRWU3ZLVm9JSU92N25qdXRlbWlNd2lxbjd2Sm82bU80UFBLeW10WSttbnR6UG1GOTNXWGQ'
            . '1TDFtdVJRVTBZbkk4WHoyUGZEMlZ1bldjc1hBZC9FNkJVcnR0Q3NYRTY2TkNKVkY2Nk5welpSQmJnYVNQVEVBcEpTZlZMZGduT1RxZ'
            . 'FZiTEpKWXFzSXNiaEI3RzEyNWxJVGd2TFFkczNjUmtJSitSTlFKWjJ1UThVWUM1YVZmeWd2RG1hSmFrQTF6cnU4S0hvQW15MDYwdGx'
            . 'ENE9Ja2FRVlZnNEFrdmNkdysraHVtK1JrOE5XRGE3QVBWVkdUaWE1ckY2N3ZVdGphN2pYYkNpeTZxdDc1Z2VwZTI0aElWcVhtcmtjN'
            . 'EpXZkcxcVlFZ29RSzhJb3NXd1hCTVRCb0JpQXBuUTFjUFpUd0NIcnY3SkM0NGdDd0Fja2JOdlVBYmFzRm54R0ZaSG1jYmhTUFZYckl'
            . 'XVWNaeldVR0kxcVU3Y3lsSlF3TDFDWVpaalg1Qk1saFNHelJLNWFIdWY1QVBUVUgwV0hTN2l1RUxGOFBuTHQzRElSTDc5NjRzUjB2d'
            . 'GlJQzdMZEF0M1Q4YlhTUlZnME5Nb1Eybm1GOEZRYzh5UGZKd3VLNWpJNURWbllYNjZ0WTJJMW1SelMvbWdNNjFqVitFRGExOWppWjF'
            . 'UWW5BNkt4dFlkVWh0OEVyYnVxWHZrYTVWa1ZsWi9MSVFsNEhsZFlrMG5QMDZua2RqeENaT1NXTTNiWkU2S0YyQmd3a1hQNml0all5d'
            . '0Z2WUljcU1EQjdrUlpOTHJKdWNJWGJhdFpCQUcyQ3RMa09rVDROaVY3azNuMEk3N2NGYlBZN2lrT3Z5MDZGY1UrU05QcXlXU0s0a1d'
            . 'lek56am5LMVFTSjloR0ova2k3UDNCcjBONmQ3SGlYNVM2QVpVQStCbHNDNWhhbkcya00vWHhTSWR5c2FoSVlzTXNkeldaN0IxaERjU'
            . 'DAwdm9FYXJJa0NPZC9lV1ZTcVMzQzdtZ29wZHUzaUdiQlN2NDYzNHVwb0h3SElvVFE2SDdVaGhpMU02TmUwSWdaK3lLdG9YOVlmUmN'
            . 'sOHZyZlMxSENFbnl4WHY1MEV6Wno4dkxTK1QwdnprckJVUE5CeWlYbGRXMHVmODFTaFMwT0d3SWNpYXhoV1RiNGptOXIzTjhwQXRMR'
            . 'VV4dVJDcVljUlFxSzMxN0ttYWNnSmRZRTdwSHRzT1J5MWhYeXBPYks0M0FqQmFKaDM5QXVqTmQ0QURaTmVmeTRheFpkMHZvY1NaVXh'
            . 'JVTJIVVFvZW9wbFNNSEFPVXFjNmFJNnpBWmxKVzJaU2p6Qkw3dS9YbXZQVGZuVWUra1ZqQnRnd0o3Wmg0VG9Pbk02V3FOeXZvdUlnN'
            . 'VhXVDVDWWpuaXFjcERic1EzTVlDdWdZaDgrZnkvaC9STC9xT050K3ZzNEZveGtoNk9kc2tiL0RzbzhtQkhsL1ovb2ZaZENJTnYyL1p'
            . 'wVG1SN0lBRVlVdnZPdUN4RkFEdUJCeWYvSDRXQmJXNlJ6YThrZ2NsTmw5TjhPMlFteGh4S1BLVUR3TVE1ckR2VUI5VmEwYnJEZEdqb'
            . 'Gw4YnZoazVaT3B1em5hTWhobzYyMkRWOU1xSXBuYU9zcHd1bmtMTzNWS2NWRmpseC84bXF3aWcxN3FMeEFuZVlkcE44TmNObm5MWXp'
            . 'RQjArSTMyUDlxU0JZTlZlVGQ4YWFRbFp3cXQ2UXNDclZYTGVsVmQ3L2QxeXhLZUQyOFA3ekNMK0gzcmxra1hYUit4K3B4UzlYMWMyU'
            . 'WwwcTF1KzY5cDZZOWwzTFhvbUtrcVMzN3pNYUJxa05nVVhpUVJ5enBxMGg2am02dTRLb043aW05TWlJRElmWDRJaXQvRkRrQkxnVlF'
            . 'ZV3hKY3l5MmNJaEorUFBUTEZMQmZjMHdHWUQzb0tuOFZuSDA0cVBLZk1WRE9GM1k3SXFTYkVsNlJwb1lvRElrVGE4UUFzWEtuMk9zU'
            . 'WxGd3ljMjBid0VLUDRiMzgwcmpFK0wvdXp6UEdQNjE1aGVqU0FUNjlaTGdJK2lJMFV6bFY1QXFwaGNuQ2ZtdTJrMjRLVkRDOEFxRlF'
            . 'idHVndVhhLzRXN0pEOWF5S0NoL290bDBHcmFpVy9HNEhOZm1SM3V4dVFXYlZvQXJ5VTV5VXRmYS9sdnZoaHI4bkQ2MGh2SlFZSmI0Q'
            . '2hQZE9Nb0ZkS3FDZE9QT1RMVFQxRjIvSzgxdkNCQTQ0Z3hvR09Cb0o5M3dhTXI5YXVGa1JuNXhBZ3JJS2pUSU1oKzF1c0kxeUZjYWJ'
            . 'XczJDRWtMRCtlMHNPTEhnTEhzZ04rTVFoZjgrdlcxcW1SeGdNRjdSM1c5M1RCdEdDRDNJTHVOME8wWU9oSW1kOHViaUwybk5QSzIzN'
            . '0s5VTRNMGJKZFJmVEJYQzRoZjBQVlEySWsvejlha0RPMjNDMUl0dm1XVXF6bzQ2YlNDL0RULzA2VUFIcjdoSnZZR282UWNxcE1zbzI'
            . '3QnQvS0ZreWlvOU56UjVzcU95SXNxL21qeGRIK0xPMGtxclZDMGJ4TXRuZXdaVjljTENtMHRKSk9tS0l6TjYyeWYxZThBeDFpRFVHL'
            . '0lUNWpnd0E2eVlCbXJBRVVnR091U3RoSHpEQjhEeC9oajRFWUdjc2NDcDRxd0dXSXRQZ3NOZHp0NjFhek1Bc3U2UUZHYVMzM0ROYjJ'
            . 'HZVlMSmZrWmQ4NXQxTmZBQzQ0STN4Wm95ZjBnellPMi95Ny9MaUpJOGJ5Qk9qTEdLTDBNeU5XNWhDbWlKSjkvWlc1R0pSSHdYbDBva'
            . 'FBqVURUQ0IxaTlkNEFKcVZyYlpscUY0VCsydHVwZzdiWUpzTU1KdXdhcDRsWWxWUzNuRmk3bzZMOG5md1BWQTBSVU9RUmR3SWhmbld'
            . 'jakVZVitZdmFvNDFZUU9PeDdkYlVqSjBhWWx4MXljQ2NwZHFWRjFYUW82UXhWU0VpTU5aaEFZNTZnZGRGcGhybzRES2FKeDdTOWtTU'
            . 'Hpwcnlhd1NNUGt1NHJOckJOdk5xY1pKdWxqRG1xdWlrbHE0QzhrQ0NoMmVMd2Q0bkJGTDZrVWpXaWdySnh2Zk1JdzgrWEp3Q3ZaU1R'
            . 'URk1ZWmJIT1FxRlVySXVYRDZhd1ZDcnlzbWtWSER5aWZmL3UrL1g5UzJLUDR1WEk1cDRQUVJiVEQzYW1QVWh5OUdCZXoyYlVYVjYxW'
            . 'XJ1UG5ZemF3eGFMM2U3dkFaUXlMYlpodGpLZ3pkUzVSQ21rNDRtdzBkMWlDaEhoUjc0THZ2THV5aDh4akFjRDZvOHo0ZzIzQi9lSHJ'
            . 'vN2xRTHI2L2MwVEwrdXlJcVJkQjlUSk4rdUFuQjZ1MldnTUVUWEJnY1NhM0hvZjg3Wk5xbTg4OERXMWpSMFRpa2NBWlFTSFUyUThaV'
            . 'DRQTmgzMk9jdnhta0NLVUplUkxoRWp3cUswTzFuN0tqZGNrY3B0K2szSFVYN2l0VTlybGRRd1hDY2tNUDlKV21iQzhvMmF5bElPZjB'
            . 'vby9vWTlLY0VwTSs1b21lMmJHVExya1BiZ3hWaUpSY1lLVzlwdGRNbFdkaEE0UHFtMy9lRFR1V3diZWxsWEFZNjNyQWhsTFVmeWQ0U'
            . 'U4xeTZUSkI3UFFER3pLRHRQa3o4Y1lhU2ZBbURrb2hBaERSNlZaNHpIU3ZVVlNpeWNidWI2VCsxS2wwcERRQ2ZqelZIaXVTTWJZNXp'
            . 'oSEo5VkRMd05scE9ENlZ2YlRDUzRPYkRzZHhic0wyNkppSURpeHVTWFcvM0ZkYWlONm04cStjeUJRZjl0SWlxZjdmSDhpNWNYK0t0a'
            . 'HZHV1AxUnJidGJlNFpQOGJUNnQ3RzZnTllySm15L21xSDExRzJJV3ZTR0FiRnVVTVVia0h4RGlnQ1A3OHR6RUczMGFDaENocTA4OEV'
            . 'rc2RtZnZIelpmbWV2emF4YWJQY0ZSM2F4V2hiZVQyRDk3Ymt1NnpxMTZGRklBS2hkMHEwSlF2d1p3YmNKREtUUC9aVVJrSXFyZjZDO'
            . 'GFIUDlmTWhKeWdyLzE0am16S3d6aGhuYy8wTzk2a0dkaUZ5WVA0eVRlV0ZrdDZzNGc4OHFIT1VmcFR5YlRraS9VT0FlQXhuaWs3RmU'
            . 'yY2hoV2J0SzlrandUV1pwQkVOcWxWb1NKOW9UbmJVTG4vTVg4d2VmaC9kNEhxVWpnQ2ZlU2hldXZFbUdqQkp3elBuY2xUQ1JtVGRXb'
            . 'FhPbjNmRVJjOGNEU0VUUG01S091SW4xa3JkQmpIbVhaY3NlTUl0NE9NYmlwMnpIWFBIS21pS0JZR3lqZ1dPTHdBR0ZKb3pRSmRrU09'
            . 'jTHkyempaa1FvZjM1clpvMkNEZFFTRENIdGRvMUpNemVaRzMzSTBpbmJXYlUyUWpuUDNjOWs2SHVNZDVESEVlWDJuM2R2NXZmaGhwU'
            . 'FVaZGs3dGZ2WEx4RkI4Rzl1VVRORUw2eGtRZmJSZHFJdTdsTTFjMjJSR0huQzdwNGhHYjFaSkFlcDQ1VE1aVDZLcVE2M3ErR2IyVEF'
            . '3c0s5dFF1QkdiYi9XYXU5b0VkSTNHQ1VBVE84amltU2xZSncvUkVCdjdReEFuZ2ZnaVN2ME5WQ3lraVpDUnAxT1lXOWlUa2g4UVVjQ'
            . 'mtydmZlWnBiUVJZTUdwc0NRQSs3STZEQS9HVDJjL1BXeW9UUENFUUlMQ2FBVmR1Q0UrbFZLRWRoaEMyZWdIWUF0ZDE5amNrTW1rRkJ'
            . 'tTkx4bmJITVZBdHhVam1Da1BTMFRyRldBRmFhOHhPdlEwRzhrZG4xWG9BU1RkVzY5dWF3V0Znb3FCR2x3dk5wRzJWK1hlTHJYRm4xe'
            . 'GdJRXV2QTdoSExmUkM2MzA3cUwxWEZlRkJEcitTeUhMaFN1b0VtbDRFOHFtQ0NKUlNtUHBacnNrQ2xaYTU5cXRFeHA1cEZrbzIxSkd'
            . '1T1hXMVl0R2M4di9hSTRXeEE1bUQwVy9qdDhVdzFmSW9RQTlBYjVhcjVvdVRtSTdHRnZCZ1ZLbFloREltUGJOM2FWbTRjaWkra05UV'
            . 'XZoeDd3eTNueE5FRTMwdnlMdzB6NXpFbnFVbDJxNm1BN2ZURVowWTRkN2tGRkg1Q0ZvNDFpbmpoNGVQTFh0M3loZnFsdDRRRVpYYk8'
            . '3Um5QMWdRU2s3VnJSRHVxQWFNbWFWS3dsczMzNTEvTmhiMlFCcjYrMzNqNEFkV2ZjM24zNEdjSkxtR3VrU3dNUXZXUDhleVNXOHhCU'
            . '1FJeTN6MHBYSWJxbmd0Y3lJcHpUREJZQUVKdlJVUzluYUl4bjREcS9KUXA3N1E2NEtnOG1UMGI0cy9iSExneUlTMHYvWVJhenN6Tjl'
            . 'mSlk3MkkxSVRYeDlzcVc3dEpZMmhtVG1FTmx6RFpXUUpLQXoyRTJHc2FVc0V3aTJnY0RRdHUwZGxvSTNHaGFYTHFmcG5OOHFRTWlXL'
            . '0N5UWJvSmt6aXJPbnYwUXBaU2VhT2dUc3d2ay9USzBRaDJsK2JnbXMyQTM1ZU55NnFLK1dyTW5ENWFpZVZ3NTFhSGgyclM0YXVRNVF'
            . '5b2xXdkZjdklVeE40WVVKamRhdkZnWFFyeUZheDFwazJQYVIzWDZXT1VIVWpsaTBuYWpjT0VQUjdNVzJRZUgxMEMxemdwcXYxKzFNR'
            . 'W9mVnZXMWVyUWJFcnYyeVB6WWw2Z0JLbjNTVTB4Y1BvMlVWemlZRTRHTmZJZDlvbndZSjJpYVVGQWxJaE9OcThPRkxZMlllTmhOWjN'
            . 'DTzc3bUJOT3NONFduUGxTb240Ykpsck8zbHM4WThMbk05bHdwdDhSVGNkRE9GZWFUS0ZpTmZmbXZnNVNiWE5VZW1mSklUaTg2emhIV'
            . 'XFONExQUXlmSXdRZ1AwRGVUMnNFVXZaVkgrL1Q3dHY0d2pQR3JidklpaE80eU1FMTc4TGdNTWJRYlpqaUlFdHFSQU90cEs1eDNFWG1'
            . 'TTE1hSzlTVTJCS214WVQ0TFJwc1MwWEpnVlM1M0FBcUdTN1NmOWd3MmowOWVVdnh3ZVNrTWt1Q2lRTDZSWDBSbGYyM0RpbXh5Lzdvd'
            . 'npUUkVkMThPY0g3MjlmaktXUkRrZ3FJL3U5Qm1FT0h1NVVkQmgvUExsL2g5NzRaZU1DZm1NNWJIRm1TYXZEc1lTOEJveEExV2xkNUp'
            . 'rYmlGcFd4OXc3SUlBVUszcUdCanQ2cjJ2L2xndU5mTitvbUxGNnQyTVdZd2IvcXdRaHVmelo0Mm8xSy9lVnZuM0orKzU0L0tpSFJLR'
            . 'zRaMU95cUxKS2EwcG9rYkpySWw2VlgxcDhTNUhEQ1oxTHRvQnRiKzd5UDFhUjNLUUVDMHNTYVdJaTVoTGRESGMxV3VROThNWXAxSUt'
            . 'uQnR3M000NnBrZDF5ak01aStCM05Qb3g4UXJZMGFka3VVMGlvNHBnMjFXVkRaT0x2cm8weDE2Y3R0eGRXSlh3VUYxdHdqZlE4VWxiU'
            . 'FN6YzlwRmRRV3ZCcDlIVEtlaE1tWWtaV1BGRkQ3S085STBFRW1kWlRFTnNHNGFvUjRYYlpkc1l3NHVYUWJ3VDQ1Q2h1bFlaZlkwdXZ'
            . 'GT3E5MVlqY0xmbmZUYTdtRDF6WUdySFNTZlZubzFwUFdKZjJYVDgxeWErbnlXRDJIZ3kxZ2luVjA1eUptdUdCc0NwYStiRUdVMkxIM'
            . 'nNoQlFYa0pvUTVwU3lWNSszL091R2Fid0hHY3htWE53bmd4SW1EdzVuekVoS2NqQThRRlVzMUlrNzNBcjhXM3E5bTNaMHJDOGxtcU9'
            . 'SWGQ4ZnVGVUMwYWJObGxLYlFPZm9FaEZnVktrL2pNdDFYcmJQcmh3SThnSEU1aUkvUDA1bDUvR0xBNC8wbWdUTEFsVXV3cm9GbW5ET'
            . '3dEZTVydUdPdG5JWUs2a2tmd25PcndlaXNIY1NSN0w3d3hFMG9WKzhQNmlrK2llNjJhZVVuN2ZUZEp3OEhvclkyWXJIVG1TQnplcDJ'
            . 'ISzdrQW5LMTdnUW94MlN2RGE2M3gvM05wL1BsUnBCRm1PdXFvN1Mzc3ZOVEZZRzJIMEhCU3lsWi9FcDJRQlZyeFJaSVlvTmlBS3JvN'
            . 'TFOWUlSUXZKS25TY1hsZDVJVFhUcVhmVzFZaEJuU216NFZpTWVEbEhwRVBwQXdEWVp1QWpLV2N0Ykt6d01BK1U5YjdERmkyWFJvVWE'
            . 'vL0JtbHJHL2pIbU9ZelAvbERKL2s1OTd1L3RjV3B1dnpRVEpkT2ErdFB6bmI3MDZyM3pRMXIvMURrVTJwRGNockN4ck1IS2wwMnRqd'
            . 'VJWRG56UE9zNGxYejArQTcrYjYzOVEvcU5hUkxCTGllMmIyalVvbGJ3b24xdHJJQ1NEMkduZE9ORlppcXhDd3ZIek9mSjI4ZXVmbGx'
            . 'NSmY5anNOaGh4d1dNcDFQbnh3azVwWXJZRVBtQ0ZwVkZicjVVcUVPVHJJM1hPTHNaTTNuVUFKSCszK1M4alhkb1BCL1VwNG9aN2VxL'
            . '2MxVS9sWFhpRHQ2ekFBalZCQnplck4weE9rL0lYNmlkVXRlVG1nU3dvMFZUeVpjUEJsemFFZDZRZTU3bFJrMUlWUGlKSm40V2JMQy9'
            . 'SRFJkMGhEUGo1Z3RGQVg4MHAzU1d2dnZqcWNzdlZJTkw2aWp1SklBMzdTL3crZHQvWHQ3bjlsbjAvdWo2cS9LK0JVbm9UdG15SGVET'
            . '1ppTEVyZmlNT21JUW9HRXBvVkcxMXhUK0s1L1pxV0lJZENXV2ZZMDJGZWV4VU5RL0tidFB5TjZRS0ljYUZoTmk1eGJJd2FtMkFRcE5'
            . 'uOUl2U3BVMythL0xPOVpOTGpabDM2cmdjOCt3cXA2Si8yZUdyN1FjVzFaS3RUN0V2NTZPcTMyVzJpb0FBa3FBMis5MXZTVlRTVGZDa'
            . 'mdWZGdNRGE2dDNkRUZ3a3BGd2w5RFY2emtFYS8xc0d4OE0xOUIyRGtBa0JOeWZFQkRKeGx5cW5rNTdQclQ5QXdNK0dIRXFrekUxUSt'
            . 'kdGlmNllpUkFyTjErYlVOekQ4ZEpCSitIbXpSTndLOHk1S2FoSFh6ckVpUVFvcUpXOUJ1T0ZRWk5PZThtYW9UNGZaMmczc3ZQd3hkZ'
            . 'jZ4V1J3TWdVUWpnbWlxdk1iRjhucXRMUHp2MlFEby96eFRFZC84Z3AwcTl4ay9wY1dtZUtZeTN5dEpBWnNoRUtpVVdqZWZvaFhnWVM'
            . 'rbkpFVDUvY0RqNzRwbjdNc2N1YWdIcXRxRDZQKzZZVmJGQ2R1OWk3WHJ2ZDQvVll0VnlTdmN6Ty9EMm14akxINk1MR015VzIyT3VFQ'
            . '2U0TXNqdjdSYXdCL0pIUExQQUxNaG5VNHM2eU81cyttM3U5TXcvZ1VtcVJ6V0NmSWJhcDlVVVFaZG4zOWhMKzVlai9ZQmtMaG5STm1'
            . 'jTFhta2gyaytTUXM3L2lMOGtsZVBGUXdFSG4xdG9vREEwNDY3ZjlLUnorYit0OWdaLzhwc1dtMmFqUVVjZ2syRUxlUU40NzJLYzZPN'
            . '2N6aEdueWQ0TDd0aG1xbmh0N09mSGV2MjNYVklQZ3VpQmdGL3lyK2hmbGJkRnpxUWJEN09LbFRXTGoyNkJiOEdtYkZTekhjWEVxSlB'
            . '5aEhmTnVXTGJ3UGVJL0tFR0Z4TFhpRTkydVhHMzdmZ0NsQTVrK2pNTGlyQkJZUWJlRlBhSFR1UHR2REowc0MwSS9RY2U3REI4ZU9UT'
            . 'GREaHFEVW9pNmo2TkU0TkMreTR4OW82R2QvL21CeWtUdTExUXg1bURjN1JJbklxekcrT3RoYy93RnI5clZGc1VyOVIwMWJmd2xMMXB'
            . '3WW55bHlNRTQvMDhJT3VGNmlKbEdhNUlrbTBZbDlSOU84aWxKT095QWkyVEpVeDB3Nm9Db0xNZFhiNkIxMGkwK3dFaVArT1dKUjByU'
            . 'WNRYlZyUVhGbWVrdnd0a1J1SVI5bUtLOER2c0I4VldFb3dzVitpYWUvZmNDaGJJOW43RkExcFdTdVJmY2RPNUt0M25kMFNWU3NQZXh'
            . 'lYkxTRzhBaDAzUkdqK1k0RXNaRk5FKzUvMzkwa01jaDhDQm9Ld2ZIbUQ3Y1FTOWtqT2l6SFBPd1gxTm44UEZPT0tLRU9nY2NSZHlme'
            . 'XdkdnU0VW90bzZBMFFkNHNYRGxvay9aa0JIZ0J4NWtjNElrMEoxMjhWL2tyeW9xMU5wR3BCQXJYL3VCdDk5QnQ2Vzcxb0h1Q3VUTlh'
            . 'GejRLK1pJU0VKdnJJTVFaaWRvSlNmVkZCNFBOaFRsUjRKcVNVam9SOGZZZ0hPcDhvNVNhOHpXc01vRlpFOTdFK3RuSUorNHJwV0NoU'
            . 'VM0SXRDNVdzY3Btek1mWWVwK2hqallNRjlYMFVJcExraFRjOFNHZ1J0Mk8xdjE3bi9TM3hOQndWZHZIa3RMZE9VSUVkbWR1SDZzL04'
            . 'vMDhlMWZIT0RLMTgwb2VkcXc5ZHYrNHhY';

        return base64_decode($encrypted, true);
    }
}
