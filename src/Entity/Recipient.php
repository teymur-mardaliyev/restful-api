<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
/**
 * Recipient
 */
class Recipient
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var ArrayCollection
     */
    protected $validVouchers;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Recipient
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getValidVouchers(){
        $nowDateTime = new \DateTime('now');

        $validVouchers = Criteria::create()
            ->where(Criteria::expr()->gte('expirationDate', $nowDateTime))
            ->andWhere(Criteria::expr()->eq('isUsed', '0'));

        return $this->validVouchers->matching($validVouchers);
    }
}

