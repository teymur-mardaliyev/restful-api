<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/27/18
 * Time: 02:29
 */

namespace Test\Entity;

use App\Entity\SpecialOffer;
use PHPUnit\Framework\TestCase;

class SpecialOfferTest extends TestCase {

    public function testSpecialOfferEntity(){
        $specialOffer = new SpecialOffer();

        $specialOffer
            ->setName('SpringPromotion')
            ->setDiscount(50);

        $this->assertInstanceOf(SpecialOffer::class, $specialOffer);
    }

}