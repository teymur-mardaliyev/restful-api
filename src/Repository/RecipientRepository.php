<?php

namespace App\Repository;

use App\Entity\Recipient;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManager;

/**
 * Class RecipientRepository
 * @package App\Repository
 */
class RecipientRepository extends AbstractRepository implements RepositoryInterface {

    /**
     * RecipientRepository constructor.
     * @param EntityManager $entityManager
     * @param LoggerService $loggerService
     */
    public function __construct(EntityManager $entityManager, LoggerService $loggerService) {
        parent::__construct($entityManager, $loggerService);
    }

    /**
     * @return Recipient[] | null
     */
    public function getAll(){
        return $this->entityManager->getRepository(Recipient::class)->findAll();
    }

    /**
     * @param array $fields
     * @return object | Recipient | null
     */
    public function get(array $fields){
        return $this->entityManager->getRepository(Recipient::class)->findOneBy($fields);
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function save($entity) {
        return parent::save($entity); // TODO: Change the autogenerated stub
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function update($entity) {
        return parent::update($entity); // TODO: Change the autogenerated stub
    }

}