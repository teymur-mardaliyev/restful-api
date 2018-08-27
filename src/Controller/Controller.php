<?php

namespace App\Controller;

use Slim\Http\Response;
use Slim\Http\Request;

/**
 * Class Controller
 * @package App\Controller
 */
abstract class Controller{


    /**
     * @var Response
     */
    protected $response;


    /**
     * @param array $data
     * @param integer $status
     * @return object
     */
    public function responseWithJson(array $data, int $status = 200){
        $this->response = new Response();
        return $this->response->withJson([
            'data' => $data
        ], $status);
    }

}