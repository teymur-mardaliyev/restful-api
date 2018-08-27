<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/27/18
 * Time: 02:29
 */

namespace Test\Entity;

use App\Entity\Recipient;
use PHPUnit\Framework\TestCase;

class RecipientTest extends TestCase {

    public function testRecipientEntity(){
        $recipient = new Recipient();

        $recipient
            ->setName('TestName')
            ->setEmail('test@me.com');

        $this->assertInstanceOf(Recipient::class, $recipient);
    }

}