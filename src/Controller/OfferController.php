<?php

namespace App\Controller;

use Slim\Http\Request;
use App\Entity\SpecialOffer;
use App\Repository\OfferRepository;

/**
 * Class OfferController
 */
class OfferController extends Controller {

    /**
     * @var OfferRepository
     */
    protected $offerRepository;


    /**
     * @var SpecialOffer
     */
    protected $specialOffer;

    /**
     * OfferController constructor.
     * @param OfferRepository $offerRepository
     * @param SpecialOffer $specialOffer
     */
    public function __construct(OfferRepository $offerRepository, SpecialOffer $specialOffer) {
        $this->offerRepository = $offerRepository;
        $this->specialOffer = $specialOffer;
    }

    /**
     * @param Request $request
     * @return object
     */
    public function add(Request $request){

        $param = $request->getParsedBody();

        $this->specialOffer
            ->setName($param['name'])
            ->setDiscount($param['discount']);

        if ($this->offerRepository->save($this->specialOffer)) {
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
     * @param array $args
     * @return object
     */
    public function get(array $args){

        $specialOffer = $this->offerRepository->get([
            'id' => $args['id']
        ]);

        $result = [
            'id' => $specialOffer->getId(),
            'name' => $specialOffer->getName(),
            'discount' => $specialOffer->getDiscount(),
        ];

        return $this->responseWithJson([
            'rows' => $result,
            'status' => 'success'
        ], 200);
    }

    /**
     * @return object
     */
    public function getAll() {

        $specialOffers = [];

        foreach($this->offerRepository->getAll() as $offer){
            $specialOffers[] = [
                'id' => $offer->getId(),
                'name' => $offer->getName(),
                'discount' => $offer->getDiscount(),
            ];
        }

        return $this->responseWithJson([
            'rows' => $specialOffers,
            'status' => 'success'
        ], 200);

    }

}