<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/25/18
 * Time: 01:13
 */

namespace App\Repository;


interface RepositoryInterface {

    /**
     * @return object
     */
    public function getAll();

    /**
     * @param array $fields
     * @return object
     */
    public function get(array $fields);

    /**
     * @param object $entity
     *
     * @return bool
     */
    public function save($entity);

    /**
     * @param object $entity
     *
     * @return bool
     */
    public function update($entity);


}