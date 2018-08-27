<?php

namespace App\Controller;

use App\Entity\Recipient;
use App\Factory\RecipientFactory;
use App\Repository\RecipientRepository;
use Slim\Http\Request;


class RecipientController extends Controller {

    /**
     * @var RecipientRepository
     */
    protected $recipientRepository;

    /**
     * @var Recipient
     */
    protected $recipientEntity;

    /**
     * RecipientController constructor.
     * @param RecipientRepository $recipientRepository
     * @param Recipient $recipientEntity
     */
    public function __construct(RecipientRepository $recipientRepository, Recipient $recipientEntity) {
        $this->recipientRepository = $recipientRepository;
        $this->recipientEntity = $recipientEntity;
    }

    /**
     * @param Request $request
     * @return object
     */
    public function add(Request $request) {

        $param = $request->getParsedBody();

        $this->recipientEntity
            ->setEmail($param['email'])
            ->setName($param['name']);

        if ($this->recipientRepository->save($this->recipientEntity)) {
            $result = [
                'status' => 'success',
                'uri' => 'http://', // ToDo: Generate GET url for endpoint
            ];
            $status = 201;
        } else {
            $result = [
                'status' => 'Bad request.'
            ];
            $status = 400;
        }

        return $this->responseWithJson($result, $status);
    }

    /**
     * @param array $arg
     * @return object
     */
    public function get(array $arg){
        $recipient = $this->recipientRepository->get([
            'id' => $arg['id']
        ]);


        $result = [
            'id' => $recipient->getId(),
            'name' => $recipient->getName(),
            'email' => $recipient->getEmail(),
        ];

        return $this->responseWithJson([
            'rows' => $result,
            'status' => 'success'
        ], 200);
    }

    /**
     * @return object
     */
    public function getAll(){

        $recipients = [];

        foreach($this->recipientRepository->getAll() as $recipient){
            $recipients[] = [
                'id' => $recipient->getId(),
                'name' => $recipient->getName(),
                'email' => $recipient->getEmail(),
            ];
        }
        return $this->responseWithJson([
            'rows' => $recipients,
            'status' => 'success'
        ], 200);
    }

}