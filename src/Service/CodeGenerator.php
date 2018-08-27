<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/24/18
 * Time: 01:54
 */

namespace App\Service;


class CodeGenerator {

    /**
     * @param int $len
     * @return string
     */
    public function generateCode($len = 8){
        // ToDo: Make it more readable (example: SPRING2018#GENCODE)
        $len = round($len);
        $len = $len > 8 ? $len : 8;
        $len = ($len / 2);

        $code = strtoupper(bin2hex(random_bytes($len)));

        return $code;
    }

}