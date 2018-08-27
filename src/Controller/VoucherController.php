<?php

namespace App\Controller;

use App\Entity\SpecialOffer;
use App\Repository\OfferRepository;
use App\Repository\RecipientRepository;
use App\Service\CodeGenerator;
use Slim\Http\Request;
use App\Entity\VoucherCode;
use App\Repository\VoucherRepository;

/**
 * Class VoucherController
 */
class VoucherController extends Controller {

    /**
     * @var VoucherRepository
     */
    protected $voucherRepository;


    /**
     * @var VoucherCode
     */
    protected $voucherCode;

    /**
     * @var OfferRepository
     */
    protected $offerRepository;

    /**
     * @var RecipientRepository
     */
    protected $recipientRepository;

    /**
     * @var CodeGenerator
     */
    protected $codeGenerator;


    /**
     * VoucherController constructor.
     * @param VoucherRepository $voucherRepository
     * @param VoucherCode $voucherCode
     * @param OfferRepository $offerRepository
     * @param RecipientRepository $recipientRepository
     * @param CodeGenerator $codeGenerator
     */
    public function __construct(VoucherRepository $voucherRepository,
                                VoucherCode $voucherCode,
                                OfferRepository $offerRepository,
                                RecipientRepository $recipientRepository,
                                CodeGenerator $codeGenerator) {

        $this->voucherRepository = $voucherRepository;
        $this->voucherCode = $voucherCode;
        $this->offerRepository = $offerRepository;
        $this->recipientRepository = $recipientRepository;
        $this->codeGenerator = $codeGenerator;
    }


    /**
     * @param Request $request
     * @return object
     */
    public function createVouchers(Request $request){

        $params = $request->getParsedBody();

        $result = [
            'status' => 'Bad request.'
        ];
        $status = 400;

        /**
         * @var SpecialOffer $specialOffer
         */

        $specialOffer = $this->offerRepository->get([
            'id' => $params['offer_id']
        ]);

        if($specialOffer){
            $recipients = $this->recipientRepository->getAll();

            $voucherEntities = [];

            foreach ($recipients as $key => $recipient){
                $voucherCode = new VoucherCode();

                $voucherEntities[] = $voucherCode
                    ->setCode($this->codeGenerator->generateCode())
                    ->setOffer($specialOffer)
                    ->setRecipient($recipient)
                    ->setExpirationDate(new \DateTime($params['expiration_date']))
                    ->setIsUsed(0)
                    ->setUsedDate(null);
            }

            if($this->voucherRepository->saveBulk($voucherEntities)){
                $result = [
                    'status' => 'Voucher codes have been generated!',
                ];
                $status = 201;
            }
        }

        return $this->responseWithJson($result, $status);
    }

    /**
     * @param Request $request
     * @return object
     */
    public function useVoucherDiscount(Request $request){

        // ToDo: Change status codes and use right once
        $params = $request->getParsedBody();

        $recipient = $this->recipientRepository->get([
            'email' => $params['email']
        ]);

        if($recipient){
            $voucher = $this->voucherRepository->get([
                'code' => $params['code'],
                'recipient' => $recipient,
                'isUsed' => 1
            ]);

            $nowDateTime = new \DateTime('now');

            /**
             * @var $voucher VoucherCode
             */

            if($voucher and $voucher->getExpirationDate() >= $nowDateTime){
                $voucher->setIsUsed(1);
                $voucher->setUsedDate($nowDateTime);

                if($this->voucherRepository->update($voucher)){
                    $status = 200;
                    $result = [
                        'discount' => $voucher->getOffer()->getDiscount(),
                        'status' => 'success'
                    ];
                }else{
                    $status = 400;
                    $result = [
                        'status' => 'Bad Request. Please, try again.'
                    ];
                }
            }else{
                $status = 400;
                $result = [
                    'status' => 'Voucher code has been expired or already used.'
                ];
            }

        }else{
            $status = 400;
            $result = [
                'status' => 'Bad Request. Recipient not found!'
            ];
        }


        return $this->responseWithJson([
            'result' => $result
        ], $status);
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getValidVouchersByEmail(Request $request) {
        $params = $request->getParsedBody();

        $recipient = $this->recipientRepository->get([
            'email' => $params['email']
        ]);

        $vouchersList = [];

        return $this->responseWithJson([
            'result' => 'Sorry, maybe in the future.',
        ], 200);

        if($recipient){
            $status = 200;

            $validVouchers = $recipient->getValidVouchers();

            /**
             * @var VoucherCode $voucher
             */
            foreach($validVouchers as $voucher){
                $vouchersList[] = [
                    'code' => $voucher->getCode(),
                    'name' => $voucher->getOffer()->getName(),
                    'expirationDate' => $voucher->getExpirationDate()->format('d-m-Y')
                ];
            }

            $result = [
                'rows' => $vouchersList,
                'status' => 'success'
            ];

        }else{
            $status = 404;
            $result = [
                'status' => 'Bad Request. Recipient has not been found by provided e-mail.'
            ];
        }

        return $this->responseWithJson([
            'result' => $result,
        ], $status);

    }

}