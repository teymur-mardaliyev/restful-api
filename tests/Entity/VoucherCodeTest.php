<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/27/18
 * Time: 02:29
 */

namespace Test\Entity;

use App\Entity\Recipient;
use App\Entity\SpecialOffer;
use App\Entity\VoucherCode;
use App\Service\CodeGenerator;
use PHPUnit\Framework\TestCase;

class VoucherCodeTest extends TestCase {

    public function testVoucherCodeEntity(){
        $voucherCode = new VoucherCode();
        $codeGenerate = new CodeGenerator();
        $recipient = new Recipient();
        $specialOffer = new SpecialOffer();

        $voucherCode
            ->setCode($codeGenerate->generateCode())
            ->setRecipient($recipient)
            ->setOffer($specialOffer)
            ->setUsedDate(new \DateTime())
            ->setIsUsed(1)
            ->setExpirationDate(new \DateTime());

        $this->assertInstanceOf(VoucherCode::class, $voucherCode);
    }

}