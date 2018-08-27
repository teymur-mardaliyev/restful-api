<?php

namespace App\Repository;

use App\Service\LoggerService;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

/**
 * Class AbstractRepository
 * @package App\Repository
 */
abstract class AbstractRepository{

    /**
     * @var $em EntityManager
     */

    protected $entityManager;

    /**
     * @var LoggerService
     */
    protected $loggerService;

    /**
     * AbstractRepository constructor.
     *
     * @param EntityManager $entityManager
     * @param LoggerService $loggerService
     */
    protected function __construct(EntityManager $entityManager, LoggerService $loggerService) {
        $this->entityManager  = $entityManager;
        $this->loggerService = $loggerService;
    }

    /**
     * @param object $entity
     * @return boolean
     */
    protected function save($entity){

        try{
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            $this->entityManager->clear();
            $return = true;
        }catch (\Exception $e){
            $this->loggerService->addErrorLogFromException($e);
            $return = false;
        }

        return $return;
    }

    /**
     * @param object $entity
     * @return bool
     */
    protected function update($entity){

        try{
            $this->entityManager->merge($entity);
            $this->entityManager->flush();
            return true;
        }catch (\Exception $e){
            $this->loggerService->addErrorLogFromException($e);
            return false;
        }
    }

    /**
     * @param object $entity
     * @return bool
     */
    protected function remove($entity){
        try{
            $this->entityManager->remove($entity);
            return true;
        }catch (\Exception $e){
            $this->loggerService->addErrorLogFromException($e);
            return false;
        }
    }

    /**
     * @param $entities
     * @return bool
     */
    protected function saveBulk($entities){
        try {
            $batchSize = 20;
            foreach ($entities as $key => $entity) {

                $this->entityManager->persist($entity);
                if ((($key + 1) % $batchSize) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear(); // Detaches all objects from Doctrine!
                }
            }
            $this->entityManager->flush();
            $this->entityManager->clear();
            return true;
        }catch (\Exception $e){
            $this->loggerService->addErrorLogFromException($e);
            return false;
        }
    }

}