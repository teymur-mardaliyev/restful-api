<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/27/18
 * Time: 02:54
 */

class CodeGeneratorTest extends \PHPUnit\Framework\TestCase {

    /**
     * testCodeGenerator constructor.
     */
    public function testCodeGenerator(){
        $codeGenerator = new \App\Service\CodeGenerator();

        $length = 10;
        $code = $codeGenerator->generateCode($length);

        $this->assertSame($length, strlen($code));
    }

}