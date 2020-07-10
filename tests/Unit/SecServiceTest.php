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
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_PRIVATE_KEY, $this->getPrivateKey());
        $this->setConfigurationSetting(\Mageone_Qps_Helper_Data::QPS_PUBLIC_KEY, $this->getPublicKey());

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
        $this->assertEquals(
            $this->getMessage(),
            $this->secService->decryptMessage($this->secService->encryptMessage($this->getMessage()))
        );
    }

    /**
     * @return string
     */
    private function getMessage()
    {
        return 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. 

Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 

Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. 

Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. 

Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. 

At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat. 

Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus. 

Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. 

Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 

Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. ';
    }

    /**
     * @return string
     */
    private function getEncryptedMessage()
    {
        $encrypted
            = 'MTU4QXpNUXdBSGJVSzJmdXM5TFpjNUNRVzFwWURab1l3a3Z6ak9uaWt2TlNjYlUyL2lPc1RNMWNFMlNoK1BGRFZLV0J2cGtBaUFDYU5mRzJGNlIwV0dRWkUyUGt4dmN2VE1vTWRkakh0b0dQQkhNVER5SEFFcCt6bWgxVUJZbS82WjEyYk5kQmhiOHhaTHFTd1N4K2ltY01xQTBEYituTk5OUldLcnloTzNmaEtaK0NYSS82bEFEczYzTlBhYTlUUmRsbjRnbC9HUXNnRW1BUk9ZU21icVZjVEFuL3EwQUh1UlJId3YxWXB0RHFYNW00Nnc0VFFWbXVVODY0d1hiRFlaSnRWbkVKcWVGR2N1ZkdtcWFFZlhiTXdpbWR0ejBHWXlaS3oxWGFuKy9wcDlOd2VDQkdXdWFTYUZ2M3U4Q296eXZCOFNEOW9QL1BrM1FEamdZZTh5Q21RPT1CVm02M2VDTmIzd2daUkZIM2hrbHh0UGxNUjNyclBxRlJrSG1ERVU3ZFg0T0JWRVQ5bkxuZzNDMHpFUzF3WVVoK3NZdEVKNHBzaGxEZnYzOUU3WDQ3cGxJYTRSaXBud1gvaHZOM1d3S1NQMG1SdStuUkMvWUtSVHRVdi9uOHpLT2ttYnVyamU3ZUhIUy80SHlISlZWNHFKY1EycVR3UTUzbENZdVRkQVBZUTVkRjF0TWFTcjlJVWU4b01SSzJXcWVENXM3bldsNHJqcHFzaXFtVmd1ci9EbThsSk5KelB0NHV2NytOVEdjRXhCenVsazNsVjYrTU5PdmRsd0RUS3ZZSkRuTG5rWjljblhINnMvNHZxUGhzK3l2aUdWY21EYVcwRnhhT2tXNmRJR1BvSnI3Y2RPaWY1ZHBCc0tSdkh5T1BLQnhtRXZoQWpRdzVreitUdnhWQlZFWHMvU21icDBnN0Z1NkFtZ3FUMzNOUXMyQlBxNTJ1aEVCUG9ucUUzM0h4UXNwRGRJSVg4N1dmS1BSQ1kyMlc5ckg3YjQzdUNMNnlXc251eGlrQVlJZCtBNEI3VDI0NEpnc3BCbXlsc3dCZ0o5M0VTS1EyVVhBaXFZd3ZrQjV1MGpvaE50RUZYM3RCc3diU3UwczJhUXBWMjcxM1VId1JXQVpYbXB5clRld2RQNWJFdnNzeUxkK2I1U1VwSGhERXlFdXZhazkrbEJ4NGw2aXJiYXMyU0tRWlNYN1RUcGlvL0piUDdDM254TXc5cGZ4M2N1NEx5WDdFT2RnYURMYW1ab0xSM3M1Y3RrU3Ivb1ZMRkdhSDVGOHd5QUxIcmdXODdDdWhZMTZ3QnJpWkwyT3BvYXpQSk9tSFBBUGhtWW9tVDJFMlBuOW52Qzc3d0tPcXFDU3pNZlBBZHpaSjdGQk9PbXhRSzU2VERtQkZFM2t5OTFyb3JRaXBpMHk2Q21nelBFVlJXRCtXSE55Y2Z5MW9aaWRxemZERVVrQzJqZmlPUXhna04rTkFOWVBncUl4d3NTNDRhOGg2Q1Bhd2NqUU43eTNQaE9KMFhML3drNWJwQ2VYUThFWXJudTJVWFJvZHJpUHhHMEM0VnhUMjhXT0ZKZmpUN2ZSdDJ2ZmxMZDV2TWVhNjlVY1pKNmQvYVpGa3BSNXJWUzE3YzQ4OUZhbEc3bllzU3MxVS96emtQNlpXK1pKOCthQTlvVzZIb09HOHFlRzVPcU04UE1KQnFBUlFJcjRRU2E2TVg1OWdvaUlVbzl2bmNzODRycnZqQ0VGeEt1bnlSTXllalI5ZzRjdzM5dHBoOFdMOGpGRU5MT0UzMWpkTlZBdWFTV2Y2bjJQR2JWc2FJd2liTGxZWmpiYVlVd1VKRTE1TkdnWXZ5TzJkblJ5R0g2WE1UV0JieFMwM1BCMGZTQ1MwTWkwU1R4aXFlb0xyeEZyUldrNkt3Y01DWHZKa2s4ZEt3Q0pJM1NReGVHUDBDMDlCcERVU0w5WExTVVBDSTJFVlFQRTFLTnlsTUpYL0dLa2lGL2c5anZVdGFjd1pvU2VLK2RmZDNxS1JRR2YxNlozR21janpWL0JJdUVQY0E4ZndScXQ0WVg4NHFTYzBMQ3ZYWGh3cGl0VkhNWG9vYUxlWm1TYUZ3d2RJZ0cxZyt2SGtsM2hpQU9ndGJZS0xPa01sbitoaGtwTFp4ZlVubmVOYTRHQXd6MENmL0Q0azZiWGxaajhocWFUdnl0OHdxVExyUmFlZFRlNG5qcXB4Y1BYUEYwSDVSNi9NQTR1aWtnVUhFa0FsbnU5aWN2UEtuT3dueHA0cXhQL1lWdHZZdjVmQnY4ODRTOXR5YUl6MVQyN2F2c0dPVDJvYW93MzA2NjREaXNtRWdFRDZkeERRd3h1ZkZCTDY3Rzg5dHJXa25MYm5NMll5WEZ3U3BpajR4VVJnblhUNXdYTTZrMVVibExUR1h5V09lRDNoQWpnMUNGMVMwTlQyQnF4MHBSQ2gzQWtsTVczakdSSUJ1OWczbFVZZ0pISEMxQUUxZ082MzI4UGN6cEE4WkUrQ0plb2VFYklMejRKREVtQ0hNOWJZaVdhYnpXczF6LzQ3K0p2YWI1QkVycUlpaGdoeVMxd2gxT0hCeVpXNnIwSWJwTjVTN2R4OWg2KzdVMzFvRFRuWWYvcks4Nkh5M2hlZ3ZQQ1RzeEF3LzJ5UE13ZlNNKzlZUDZQZ0hlaWpvQ0F3c1NrRytFMzhmdDZweWUxOVU0K05pOFF3cG9zWlNkclhZajViMTZBWkdUSlBHdVlIWURZOUFoTjZiTGZ1VmVUbVQxT2VsZSt3Y25zWUlOY29wc0dWNGN5ZEZzbXBLdWY2V3diTzBkUWhNNDcvZHdqL1k2QWYzb28wV3piVFVvZ3lPQ3hIa3BGUTFyWkF6UHBPSFNVL0ZLVmw0c3ZqVVFCYXNPdTNuMnN0d1dOQU5IZWZOeEx0czgrQkorTUJRQkVWS0oxUXZkNEdCY2xQNlMzK1BJc3ROZUZGcEN5Zzl5UjNEM1M4cm54N2l3bERRRDJPZzJLN1lqYW9veG9Yc2ZmWHU0cm1GcytoWkVHSGxueEZKRjl2NXUvM0Z0VGFFN0lhVm0wT3Rza3h0SXR5ZEFmNEFFaFJCZEZlUzF2Q3M2SWdwdGx0c1ZyR2ovTVdtekQyQVIxcXNkNXFhYjI2VTNXN1g2U3JEUGFqbUpxb3gyMTFvTmlYcXY4RVpGOWxDa3RaN1YzTE1oLzQ2OTlIQjhKU2NBRC91Mis0UW45U3NuQUtvb2tTWjNVWkZmQTlHcU1SQmJxdFQxMVNZWm9JckZUdnF2UlpFR0kzdTI5Q2JaS3BvcEpJOTBCa3c3T0l5MUJvdGE4SjRCQ2I3ZE1zcDlKR1I3elAyeWkvTmFlODVHZWdCR0R0eUFCajVlakxER0lBUGo5c1ZERVdlNFZoQUx2OGNMSlVVMHhHN2JjQ2JySXVvM2U0eENFSDIyTnpGdVlDUU15b01FdncxSTNTRytseGEzdnhpUFNLc0h3Z1pwTnluUXBMNHo5SW01ZHkxOEhwdEc2ZG43WWU1YlUrMkxlV1JpOVhYbDlHeWF3d2xFdGdqV3QrejRZQkdOOW1PSHc2M2V6WnNMVlptMVhDcGU2Q3IwbzJpY1J5TzBKYWo1SnVzbzl1eW5wM0VaNnNtcHBWdkJtMjFFdU9hS3dTaTBxT2RRQUFLU2dMMEJBMXlZaXh4d2lKRHVzMVRUMkxhKzdyWkJkWjM4Z3Y1ODdLdThxRVcvNnk2cTNXNitCaUg2YUdhRTB0NHZieStwMWcrbElCWlRQaE16OEk5blVxSThNOFc1L0grZjlxcWY0aFZiZWZlQTFQcTJRQ0pURmx1bE1MUHFubmdDbWVHdTNBQkdXV280WWVSR0FUcElpNWJoQ085ZUVVcmw3Y3hJa2dJaFFiZ0VlenRUSjJRTVUvNlQxSDd0M1l3QkpaTEQ1ck9NeGZ4MnlmYzQ0VWdLd2VNVHZJdHdXMFZSMVZURUtOUTkxbS9kSjJEMC9wQTJ2dDI2bHVkbFFsZkRYTm9EYzBPcXZvSDNuUWpoUWJDMUFnRlBESmdLZnp0TFlrajgrS3R3dS9CTG5RTVB5eHYwY3BRbXZKSDU1c1VFcDV2OENuR3E4TFMxNnFoS05sOGhNVitHYU0ydWtaZnA2eHJiNWhhSUxWclNsWDZxYTR6U0NGTXJWTFBZSGpNbDhZcm53QzlaUW4vRWF6c015L21FNkFBMjVxU2FscEtQN3ZpZXNWZHR2S1NGWlRlZE5HRW5EVTlLYlFNUW9mUlhYYXNIazhDdGw0ajlnQTE3SXNXK1NFTTVPWFlwekxHSmRNUnRpcTVPVllpSGYzdDUyR2IxNXJkNjhROXhJNjJuNFN6SUVnekVQNjJvZW5ienpvNXUvaWlUNGQwb0FhTDJrVm1QT1V1ZGx6ZVRvejg4NDJ4YkVIUzNmZkorNDY1cTU3dkhmcHJ4azJEdUJxM1hjS3hHc0l3UGhjd2ZEYlh5cW9RTy90bStrSnJYc295dDBZYWFSMnRQWUdzOVdmd0FueFhFT3d6VHhIM0RpWmptZVcxL2tFcEV1bnFNKzNMbitJRHhwUWFKdjh5S2NtTExTbmtIK1BuVmlHeHlBS0VIVTQ2eDlDNWN1NVJjcXlBZmx3K3hHQmRRODkwMVltZkRUYW9hTW9wUlh4emZ1SnJ5d0hjS1ZHa01mNFZLNmh1ekJyMlZCMjlqYjlHWlhtZGZkZTBXWFp4RHNpMlVlNUtLU0lIWEhERlJYUE9QMndDWTB3UWxGQ0t0V2d5QmNBRURpUjBFQldLNmVJQXRhZmRkQmpsYS9sbjREc2pIV2JYWFRLdk0xRnFSN3N6TkhBZ1B0SjlMMHhUendGaXdFMElWeWZYdE8zcDBXZ1kzTTV0K3NVV1R0dEhYY2hoQVVpTUxXdjJHdTZnTk1kSHRseTFDbElaa3FCK1U0dWQyRW1icjlCd0ttNHdIL2hOTUtJRnZDM04ycUJKT3U2cnEzWWRCUHljczdqUVZuR3VBM0xiSWlRcUlSUkRNZW85L3dZOGdueFc2VnJZQ2hNeTk0ZE81ays5Z2I0cUtkem1XNTdOOW1YTEhabFF5a25uNEFySytBY2NrSVFSdnFjVU1TMHJFK0FCTlNMVGFjNU5ZMmJWVjJ4Qy9ZTXhEN29SL2hRM3RIb0NlMm1OUWZOV1owNjhMQi9PeHVObEl5V0dxSnVsb0xEQWl5YXAyNmxRZWFtZ0RKZ09LOHY3T2hwT3NQZ2xZWUJMdlI1ZmI0LzBwK2xyZWJVdXl1NGthMTRZMGxzcTlvb1JlUFVuaXEvMTZuWm9UMVNNWER2NktOdG5PeHhGR1lnNFpZREhNZFdoYmgxaE8xTTdNeng3K1Y2bXFWRVhvY05TZUZRUklaeEtaSWJvWjIwU3N4dEZ2MnZJKzJuVjE4Q3IrVVUxT1U5T1hGZlFXSWplSkoyanhqNzJWb3RwZm8yTllVeEdzNklYQXRTaHl4OHB4NHhMdnVNZkVka3VEOWthb2JjVGRzcTFTdWJUdjkyNGlIMUFGaitOV1ZyWStURWc4c2NqejJFKzQ5aytRZmdIOEQxKzFrRThmdFVqcWM0R2ZTVllCR3FFWEFyMlZIWXh0Y3lWRjZQb056UFJ2cE04eEcwVHlJVElST210anhiczBrRDNCRTVPdzZrYmRxZ1UySTdkbUt3YjBvQTVyRE1vaEtKNHZXRTVzYno5bWxQR0RVNkZuUG1XczZMdFlYSVRxbC8zVGlSZ2ZWY25NQVpwOHltN0tSR0h1SlFmL25nZWFJZjZHNC9xUEptVEpzNzdNZHIrN1oxRjArQUtXOTlGNW4vc3VvSjFLRm4zT0lZa2Y1bDFzREdqOGpDdjAvZDBUYmhGWUt6YU54T0tJWklwTXN2VjhURlpGUTJQQ1piVGorU1pCVkRwaFduNFk1ZTRtd0hUWXJhVDc3K2w4eit6NVJKTjNTMFBvcXBLRzd2SmZWK1RyOUcrREdmZzAxZ1hSYWFzekVrQTBxb09LVTl3dndMU2J0THROWHI5cEVDNkNnU3U3RFUyT0hQYXRhNksrbWpIdFdUTHlwK21VUjZEUzk3ZE54dVc3TCtiMlUybERXd3FWc1NNTUQzMkdjWitPOWZIUlRlSDVXNEJuVWRLWDVHVFU4R3U3YzB4WmxtOGNBemFMQXZER1F3VVQzN0tjYzZYSFJHNEJQU2VYbFdCY1ZLRDZHZlVqdWVCbnF6OWs5dytPQTVma2U2dDBhWUw3RlpZYWl1U1R1S1RadWFpZ0xxaHhhcGxKcGQxZnp5YU5hMlpKb3IxRGdBdkRYMmNrVDBNcWg5Y09IVEZQYzJWbG4wWXYrOXZYb3h0a1FrWERxdXhOYXlWSTlrWlRpakhHWmtLWEV0QlMvK0xVSVdWOVNrWEswNEpVTDlVQyt6Y05EdFhVZldld2s4ckNDSTVHU0JZUTZsSkRGQ2VoOHVsTGd4VlZ2ZTV4V2dTeUQrRERKTXBHZXcwYnlvZTBBQUtWSnkyTU9QdE1UY2V4QU1YYmtrelFWb2RsMVg0a3hXanh2SHArd2k3VnlwcTF1QkMySGplTyttVDNQTjV2UFdVMmN0YzI5T0szWHNiVEc2VnppNktyMm5DREppUEhkRFdvTGZqR3lUQUlENFR0TG1mVndxKzBQNGZqd0VYeVlzcGppU3h5ek9KTTR6RnF4bHhrOXNZd1VUZ3NhZG52TER3OTVramFkV2hzQzZTWmVMR1BtT2hMTCtKTVhEZEVoVmcyeVF5c0xQOENXeFZPNCt3ZmxleDhwTWZmUGRHaXRXckR4ZWZiSUdYQVJuYlVzS2RZNllvTURYaVpVSFB5c3hKUW83TzV1cDIvMkNFVHF5bEZqdEJDekdNTW0vNzJmVjdMZ1VVN0ZVenFDaUF0OFJHdUFWbjRuSDMzcHNsNGgyM01EZnJNVTRlWUZGb2JuS0xPTzdtWnZyd0swTzcxNXRxVUliRUg1bkFzNnhxZHNlbXRKdUJHNnBHUlU1SnJRYnVURlpsYnZMait3cXZTM3Zvbm1YZmZidzBER0VTMzgwb244NW1IclhYZ2FrMlRDUVlsdUZqaEtMNkU5MDBKdlFCTU5JbDlxaXRtR3lLekUrWDh0V1FBYU9nTkhaL1pRTURDdzFOWGdNa3BWNXhrUm9saU5qaGtNNVFyeEJmMXBCY3BFK3JwbDRNaTVFbS9VSmhoUzhyOFUwcU1JSXE5RUF3RjNFVWhOZm9IUHZzcFVvNkJWWUtmNEJGUWVRYk1aYU93Z2trdnhSaWRxSkZpaXdWWGFNRHpXMDc0b2RoZTJleU9rM0tVZlVWY0R0OVU3UDdRQVhSYTNlUURpSmJMZ28rZzRtVzdKcVRpM0NaT1VHWHRPS0hwZWUyeHBxRWVNN1ptZnlMeThZSnhDeUwxdkRMTFJVTndmTElWWUZiZzkybm1yYkEyYWQzUWdYakhrVUx2MHdvMUhJQU5CcjJxUVRIdmxxWG5iV1FsdVZ6eG5kZHc1Slh0ZjQvVmtsTnJMWk1sNVV3a09YU1BtOWhkY0JDbFpVT2pYaXdMNXJNbHlBN0t0Z0dEdEZzbUJGZGpId3pNS0hzZ0hBNkcva2EwTE5pMnRTVEFZdWgrNktYTXlrbjVvazFjZGhWaTVIaUxjVmJrNnEvTXE2ZU5NRlBwcUFxQW1sZ2xTMzcxazlXQWhLT0lJdUJrZmRtNGVrS1h1cjNFOGdBcDhLZnlBQkp4MUwvR0pWQXhSWitQdUVjTnl3V1VCLzVEZ2VVd2dJZkV5RTlKUGc0ZjA4OVQrQU9QN3k2cFdaR29HS2ZnVU9URVp3K0xRd2tuTFkrS1FyWHNMOFU4RFNGblcxVFBlRzhBdSt5U04xYTExWXl6STluNTF5SFVHMVVEYitiTzdYMXl3akJ2TFlucDNBOGFWNEdOeGFtZ3F6MWx2SnhTS1ZSQXpsNnFMTzM0dDBwVzR2UUdWVmt5VlNPQ2RvZ255MG5oTEROV051ZUtkeGJGbmNDUEtibE9TRmJTSk4rbUI3VXFEd2JocHpnVU5YUjFKTVQwVDM3Q0ZWaGtzMzRjbXJabDR3ZjJDWHN1U1dMNVJETXd2d2xtOWVaYmM1SW5IKzh1a2hkdFhYc3lRQjcxMWwwajlhNEpHRDNUdzhSVnp0UGZ6VllzM1ZNbjMxbThLNyttMVNyMURMWXNoYnZWZGFjNy8yMkNHMzNTMkl6bFRwQWVjbVRkSWhkUUVnaHNnRnhiL3hhS09jamJTcVlnZmtSQXhHeUg5Nlp6a2NEeWxCOU5ERUxoWnRJNzhSMG9XVi94b2lSK2NuTEtUblpOUUk5WjlCL2xMYmphU1p6Nk1VdmlQcnFSTnZINFYrckVRdHBMUzBaVG1sbFA0UmI0dEhUMXNhOHllN2h3cWJtVnRBYkE1SEZVdGlKZHJEQVJBOHY5K0MwUDhob3hpL2hPSTRqTzZZOXJZTmJlZS9JSzRjNXRmcDNBN1VsSnM5RkdpbGFTc0dvdjNJNTY0M1N4YkIxZUkyYzNoZzRHVFFJaTVIQUxkRGV1S2ZLVC84QSsvY3Y2cHFTK0ViQVMzWTJnZENpQ2liaGp2RHErTDRFSVpVY3Y4UFdzbS9rMUtPSjJGT3B2ZlZuZU81Z29TVE9xa2FRak8zNmphaXZzNFZjYU1PbUFmWlYwMTQ2RFdGc0twQ2loMituZWZxQUtGdlpOaDNCaTRhbE45Sm9VUGQvM0hpclZlcUVuRnZNbmJ5cVhSMjhYVGZMYmgyN0FMUFJPUFhXWnRaMjU0L21vUkRkT3hsbDFLMDhDbjZhT0tWQWVTUWtVczNhN2poeHZ1VWZOdy9oSTJseFl1bk14UmtLU1h6K01JaU10cGpBYlRPd3ZVS3A2T1BSZWZXMzhYd0tsU2dJVzhTUHFIa2pTNGw2bzJTNGlocGhuOGVRbE1UZ0MzSldJcjJuZ0VoWjMxNS9pU24vWDF4cUNDR3B4WXFuVjMwZU5yZTVDNnZGdWltMEI1SFlJT1VpVDdWYWh4LzM4a3ZKT2lVSGxacks0V09LZnZLS3g3NitEZlZvbXEzZnNNMGVVc0ZIN0VaY1VoM1ZBSFJyR3JZT0ozNHVxUU9GU21nV0FUWXp4ZVAvQ3ZjRzM1SVlKSGJaYllpd0I0RVZua2RNSHJFdHJ5V0I4cGdtOGJsQ2s4VndtODIzbWxGVXVDZDU3citIOGNqZlBjQ3NUOFhoRjlTNDhTeGhYaU9tSXlmZjNaN2p1dnF5ZGlDemNWOFZKRkRQNllaNmx2WUtxVyttd2QwNUZZU0VhTkVNMVJ2Nnl5MHRuZ0l4aFkycFFJaHo0Y1hVVnB2RVVkUzhVUytNS3JiZ09veUVOeFFyUElySk9EOXlFQU9lWmlIT2VKTzBOT2d4WmdBU0UvN3o5KzY3ZEl5eGdna3NaUEZIbzA1SnFhdFNrVlZIRmU4TGh2RWF6Uy9yVGRHTUF6N1YzT3p6bFZ4U0M0MWc3Z2NJZlNDNlk0QmlQQ2N6Q0ZpYUJWUnhSTitkNFhVTkNqN08yMkYxYXR0bHlqUVBWbWNZSE1sU2gwRzFPaEJrQWpDWGlsRm8wd09LRHpncWxkS1B2dmVBTEkrZldvZnNvSXNKbndMMFJQdUFNMkVGRldRcm5PUitjQkRtSGJLazUzc2REVGRaQUJ0TEpZZUZ5YjEvL2hOYzZvbTRmcEZickJyOFVIa2tGc2hzbFRRRHVaR05NS1lRbXEwVXRjTjBPdHVuQ3Z3d2pOUWRSMU10aDZnTnRhNm9TZnNDcGN2TjVQWmhvNHhnOUhWWWJzVmQ1YnZYaVZhditGNzhrNEUvb2h2dWplRmRiTWcrMVd2ajdMWGxzbVpSaDhWdENvZUkzaUFEcXJHWHBFTXlnY291aWxqOFVmWEdOMEhqTkprZU1mcWNJRWlxV2FVVHIrL1h1RkpqdkpxSlVTVStiTFZZaWNRcGxsVmdBNExtUlc4cktreTBlQVFyWkxDOTZUVlhrNGkzNEVUWjlXeE9lUnFObXdxdU0rTjlqcmdnekZFbEtPMXZGZmtPZFBBTEJCekgwNHVPM2l4QzB3cVgxa0tMMHc5UjhydCs4bzI5RVlwYzVCUk41S0tSQzU4TmhPbHUyWU5hT2g3RHNBR2hrMGYwVG1OVDBMNUFGQkxHeTIwWG9wallyZ3N5QUxvTlZiQmlhU2l6cU1FSk4wRmF6UmgvZ1hINkJ6YUlRVkhQNEZrRmxqQ245NEs4aWNjOFRFRnpJOFlxdks1RG8vK1FLRW85ZjhNME1RYWJwZm94WURGVWE4SkY3eUtibVRJS2tsOGlLUG05amY5TkN4cTg1RmlyY3pzVnplc1o1WEhiM1Q2QnJqWC93NVF5ck1tdTJwQ2tUcFFMWjRPWWpqcE5YU2pxdWdWYkwxQ0xZUVNJdUxvRi93d2dzQVFxN0VKdmViWkZObW1KODZZTndZK2xTcW0xSzVBSi9XK2ZacURMWEwxQkJqdGJ6dlhBcitQc0lO';

        return base64_decode($encrypted, true);
    }

    /**
     * @return string
     */
    private function getPrivateKey()
    {
        return '-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAuCW8CyWqeDXW6E93D+u5Tlq7Ys0mpLfQUbBdEivwPHKgWwYg
b4OA6vTqYObb7OqXUDU/lznCSGvhD+CbQMxyC0603/LO2y7/cGBQHODBh8EKpzd2
E0QUoO7Y9+JKcrsSwIqgULxRbMqcIfdXFaZSIjHU3OcOXgfb8DhWZi09FcJs8mjD
QNHPP+6PwK/uFue3YYyN8SUUU2ot0oielMCsML4JY0Nrj0jZkLlkufZdxMF8zLF2
1AwP/sX8imSkaj4895EnqJ6cpEaTOgj2UlcFoypW5qu4Pe2F4QBEl4E2o8ltmqsn
3EphqzrEphd4FSt8f2CbSztLQ046asfCcRDoLQIDAQABAoIBAEUTop5r2q6NQ7iR
VpBaVIDX+ELvwfc4HKUIC2GtqciDFzQN8Ezkf4+jn+gJsaYFug0UbG5F9GNGVH6o
OpTsHDuxopf/dSkzUA7Pkj3C8dYCzAQ+AcToXPShpDIYaOTw1+/yEIE4ozK0Li1v
ovM0GMtK9haHdhQ/znkmKQLbJXbrfKgz5J1v9IJ8+k1WmjUrLumFPvCEcBoBvaIV
ygsBBS/Sum96lVvYC9SjtGJcE+RN3DP7yXeJdgjr564GTZO7PEtWjGe2kbsNkCd/
vJQy2gRzFQ1nk8TnYr8x6vOQKCUUSelvucaIYXsOIuicpCV5FD3ePjx9VBIBFiG6
KL/lzwECgYEA6g+IC6oKQgcZytwJAd5sZuk0BxVQk2IibgDQXpt5s/PRJVYRWH45
TzTRrZRgN8MFWDTAG0RSKAuw0vrBlDOaPu/29xV/Es78gKbNt6cR158iOo7CQepN
rw1ADHd7zMhHpj1/9izDu+BMITTJAxjWS29HitEhVzgZHZmZLMEATXUCgYEAyWh+
yDyC4xXTuDTd04XRKRm//QKdmTNn/hepS4uH8lCA0bOBf4w23Uh/57wIYSZ0aTf5
YbEEqDIKvijGWQB7q/zo1V9b654l4l8VNvbAaIEFbeUmrhhcXWGn9GxhbaKQCN3G
xtJoqEGQcLjfBuqIvYczLgWve2xfQ5vHl6pqQNkCgYEA5x0+8IWOa3Qne6+ZFUdT
MqrCvNvHHECiToxvM3vByHbP5VX++qpoXFWDVSpVd7oR5O7xYfssRG6Gw0znKDdr
7wlziranKyNHIKGUL+vAKnDvk3KzTfLVkiw7OhQhIiwA052WZLX+79yiT4eXlH9J
2mKe+etWSJET+65XGWHZsqECgYEAkNyAu8KSHYTYd9hGaFoKO3aS2Qallcgcluwr
zvM3v3hZfvqOPM/7siLwJBvhJwcCmZ8x1ir8/4Cmq2kmaGNpkCVizf09XvWrp+rd
ll/ZuhB6eDVmIbfRzzRrGelOFg3jbQ0eaGhz7/jgS8McXpwX58GzdPmP4sTqq/UC
lLp0m9kCgYEAmhOvUdyfvSdTM+EQNpF/+nQxIIeoJ8fQICayKzfTt/JxoZagnQ2L
ttN9LdCCHb6T79AHfi5n6Wjl4xvtYoQ3chpLFoy7fXuLgUtGxDiK7KQQMdCg9bb7
3wj6lTv0HrUnekjMhrAwa/LUx0eahM8w8vRG9K4xUX5nX2bV0cbG8Cs=
-----END RSA PRIVATE KEY-----';
    }

    /**
     * @return string
     */
    private function getPublicKey()
    {
        return '-----BEGIN RSA PUBLIC KEY-----
MIIBCgKCAQEAuCW8CyWqeDXW6E93D+u5Tlq7Ys0mpLfQUbBdEivwPHKgWwYgb4OA
6vTqYObb7OqXUDU/lznCSGvhD+CbQMxyC0603/LO2y7/cGBQHODBh8EKpzd2E0QU
oO7Y9+JKcrsSwIqgULxRbMqcIfdXFaZSIjHU3OcOXgfb8DhWZi09FcJs8mjDQNHP
P+6PwK/uFue3YYyN8SUUU2ot0oielMCsML4JY0Nrj0jZkLlkufZdxMF8zLF21AwP
/sX8imSkaj4895EnqJ6cpEaTOgj2UlcFoypW5qu4Pe2F4QBEl4E2o8ltmqsn3Eph
qzrEphd4FSt8f2CbSztLQ046asfCcRDoLQIDAQAB
-----END RSA PUBLIC KEY-----';
    }
}
