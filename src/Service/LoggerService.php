<?php

namespace App\Service;

use Monolog\Logger;

class LoggerService {

    protected $logger;

    function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function addErrorLogFromException(\Exception $e){
        $this->logger->addError('Database Error: ' . $e->getMessage() . ' 
            Code: ' . $e->getCode() . ' 
            Line: ' . $e->getLine() . ' 
            File: ' . $e->getFile()
        );
    }

}