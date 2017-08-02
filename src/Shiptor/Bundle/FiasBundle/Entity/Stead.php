<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Stead
 *
 * @ORM\Table(name="fias.stead")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\SteadRepository")
 */
class Stead
{
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=250, nullable=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=6, nullable=false)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="region_code", type="string", length=2, nullable=false)
     */
    private $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ifns_fl", type="string", length=4, nullable=true)
     */
    private $ifnsFl;

    /**
     * @var string
     *
     * @ORM\Column(name="terr_ifns_fl", type="string", length=4, nullable=true)
     */
    private $terrIfnsFl;

    /**
     * @var string
     *
     * @ORM\Column(name="ifns_ul", type="string", length=4, nullable=true)
     */
    private $ifnsUl;

    /**
     * @var string
     *
     * @ORM\Column(name="terr_ifns_ul", type="string", length=4, nullable=true)
     */
    private $terrIfnsUl;

    /**
     * @var string
     *
     * @ORM\Column(name="okato", type="string", length=11, nullable=true)
     */
    private $okato;

    /**
     * @var string
     *
     * @ORM\Column(name="oktmo", type="string", length=11, nullable=true)
     */
    private $oktmo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="date", nullable=false)
     */
    private $updateDate;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="stead_id", type="uuid", nullable=false)
     */
    private $steadId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="stead_guid", type="uuid", nullable=false)
     * @ORM\Id
     */
    private $steadGuid;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="parent_guid", type="uuid", nullable=false)
     */
    private $parentGuid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="prev_id", type="uuid", nullable=true)
     */
    private $prevId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="next_id", type="uuid", nullable=true)
     */
    private $nextId;

    /**
     * @var int
     *
     * @ORM\Column(name="oper_status", type="integer", nullable=false)
     */
    private $operStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="live_status", type="integer", nullable=false)
     */
    private $liveStatus;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="norm_doc", type="uuid", nullable=true)
     */
    private $normDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="cad_num", type="string", length=100, nullable=true)
     */
    private $cadNum;

    /**
     * @var int
     *
     * @ORM\Column(name="div_type", type="integer", nullable=true)
     */
    private $divType;

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Stead
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Stead
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set regionCode
     *
     * @param string $regionCode
     *
     * @return Stead
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    /**
     * Get regionCode
     *
     * @return string
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Set ifnsFl
     *
     * @param string $ifnsFl
     *
     * @return Stead
     */
    public function setIfnsFl($ifnsFl)
    {
        $this->ifnsFl = $ifnsFl;

        return $this;
    }

    /**
     * Get ifnsFl
     *
     * @return string
     */
    public function getIfnsFl()
    {
        return $this->ifnsFl;
    }

    /**
     * Set terrIfnsFl
     *
     * @param string $terrIfnsFl
     *
     * @return Stead
     */
    public function setTerrIfnsFl($terrIfnsFl)
    {
        $this->terrIfnsFl = $terrIfnsFl;

        return $this;
    }

    /**
     * Get terrIfnsFl
     *
     * @return string
     */
    public function getTerrIfnsFl()
    {
        return $this->terrIfnsFl;
    }

    /**
     * Set ifnsUl
     *
     * @param string $ifnsUl
     *
     * @return Stead
     */
    public function setIfnsUl($ifnsUl)
    {
        $this->ifnsUl = $ifnsUl;

        return $this;
    }

    /**
     * Get ifnsUl
     *
     * @return string
     */
    public function getIfnsUl()
    {
        return $this->ifnsUl;
    }

    /**
     * Set terrIfnsUl
     *
     * @param string $terrIfnsUl
     *
     * @return Stead
     */
    public function setTerrIfnsUl($terrIfnsUl)
    {
        $this->terrIfnsUl = $terrIfnsUl;

        return $this;
    }

    /**
     * Get terrIfnsUl
     *
     * @return string
     */
    public function getTerrIfnsUl()
    {
        return $this->terrIfnsUl;
    }

    /**
     * Set okato
     *
     * @param string $okato
     *
     * @return Stead
     */
    public function setOkato($okato)
    {
        $this->okato = $okato;

        return $this;
    }

    /**
     * Get okato
     *
     * @return string
     */
    public function getOkato()
    {
        return $this->okato;
    }

    /**
     * Set oktmo
     *
     * @param string $oktmo
     *
     * @return Stead
     */
    public function setOktmo($oktmo)
    {
        $this->oktmo = $oktmo;

        return $this;
    }

    /**
     * Get oktmo
     *
     * @return string
     */
    public function getOktmo()
    {
        return $this->oktmo;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Stead
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set steadId
     *
     * @param Uuid $steadId
     *
     * @return Stead
     */
    public function setSteadId($steadId)
    {
        $this->steadId = $steadId;

        return $this;
    }

    /**
     * Get steadId
     *
     * @return Uuid
     */
    public function getSteadId()
    {
        return $this->steadId;
    }

    /**
     * Set steadGuid
     *
     * @param Uuid $steadGuid
     *
     * @return Stead
     */
    public function setSteadGuid($steadGuid)
    {
        $this->steadGuid = $steadGuid;

        return $this;
    }

    /**
     * Get steadGuid
     *
     * @return Uuid
     */
    public function getSteadGuid()
    {
        return $this->steadGuid;
    }

    /**
     * Set parentGuid
     *
     * @param Uuid $parentGuid
     *
     * @return Stead
     */
    public function setParentGuid($parentGuid)
    {
        $this->parentGuid = $parentGuid;

        return $this;
    }

    /**
     * Get parentGuid
     *
     * @return Uuid
     */
    public function getParentGuid()
    {
        return $this->parentGuid;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Stead
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Stead
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set prevId
     *
     * @param Uuid $prevId
     *
     * @return Stead
     */
    public function setPrevId($prevId)
    {
        $this->prevId = $prevId;

        return $this;
    }

    /**
     * Get prevId
     *
     * @return Uuid
     */
    public function getPrevId()
    {
        return $this->prevId;
    }

    /**
     * Set nextId
     *
     * @param Uuid $nextId
     *
     * @return Stead
     */
    public function setNextId($nextId)
    {
        $this->nextId = $nextId;

        return $this;
    }

    /**
     * Get nextId
     *
     * @return Uuid
     */
    public function getNextId()
    {
        return $this->nextId;
    }

    /**
     * Set operStatus
     *
     * @param integer $operStatus
     *
     * @return Stead
     */
    public function setOperStatus($operStatus)
    {
        $this->operStatus = $operStatus;

        return $this;
    }

    /**
     * Get operStatus
     *
     * @return int
     */
    public function getOperStatus()
    {
        return $this->operStatus;
    }

    /**
     * Set liveStatus
     *
     * @param integer $liveStatus
     *
     * @return Stead
     */
    public function setLiveStatus($liveStatus)
    {
        $this->liveStatus = $liveStatus;

        return $this;
    }

    /**
     * Get liveStatus
     *
     * @return int
     */
    public function getLiveStatus()
    {
        return $this->liveStatus;
    }

    /**
     * Set normDoc
     *
     * @param Uuid $normDoc
     *
     * @return Stead
     */
    public function setNormDoc($normDoc)
    {
        $this->normDoc = $normDoc;

        return $this;
    }

    /**
     * Get normDoc
     *
     * @return Uuid
     */
    public function getNormDoc()
    {
        return $this->normDoc;
    }

    /**
     * Set cadNum
     *
     * @param string $cadNum
     *
     * @return Stead
     */
    public function setCadNum($cadNum)
    {
        $this->cadNum = $cadNum;

        return $this;
    }

    /**
     * Get cadNum
     *
     * @return string
     */
    public function getCadNum()
    {
        return $this->cadNum;
    }

    /**
     * Set divType
     *
     * @param integer $divType
     *
     * @return Stead
     */
    public function setDivType($divType)
    {
        $this->divType = $divType;

        return $this;
    }

    /**
     * Get divType
     *
     * @return int
     */
    public function getDivType()
    {
        return $this->divType;
    }
}

