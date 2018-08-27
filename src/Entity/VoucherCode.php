<?php

namespace App\Entity;

/**
 * VoucherCode
 */
class VoucherCode
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var \DateTime
     */
    private $expirationDate;

    /**
     * @var boolean
     */
    private $isUsed;

    /**
     * @var \DateTime
     */
    private $usedDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var SpecialOffer
     */
    private $offer;


    /**
     * Set code
     *
     * @param string $code
     *
     * @return VoucherCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return VoucherCode
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set isUsed
     *
     * @param boolean $isUsed
     *
     * @return VoucherCode
     */
    public function setIsUsed($isUsed)
    {
        $this->isUsed = $isUsed;

        return $this;
    }

    /**
     * Get isUsed
     *
     * @return boolean
     */
    public function getIsUsed()
    {
        return $this->isUsed;
    }

    /**
     * Set usedDate
     *
     * @param \DateTime $usedDate
     *
     * @return VoucherCode
     */
    public function setUsedDate($usedDate)
    {
        $this->usedDate = $usedDate;

        return $this;
    }

    /**
     * Get usedDate
     *
     * @return \DateTime
     */
    public function getUsedDate()
    {
        return $this->usedDate;
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
     * Set recipient
     *
     * @param Recipient $recipient
     *
     * @return VoucherCode
     */
    public function setRecipient(Recipient $recipient = null)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set offer
     *
     * @param SpecialOffer $offer
     *
     * @return VoucherCode
     */
    public function setOffer(SpecialOffer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return SpecialOffer
     */
    public function getOffer()
    {
        return $this->offer;
    }
}

