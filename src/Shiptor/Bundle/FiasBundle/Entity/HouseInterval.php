<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * HouseInterval
 *
 * @ORM\Table(name="fias.house_interval")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\HouseIntervalRepository")
 */
class HouseInterval
{
    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=6, nullable=false)
     */
    private $postalCode;

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
     * @var int
     *
     * @ORM\Column(name="int_start", type="integer", nullable=false)
     */
    private $intStart;

    /**
     * @var int
     *
     * @ORM\Column(name="int_end", type="integer", nullable=false)
     */
    private $intEnd;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="house_int_id", type="uuid", nullable=false)
     */
    private $houseIntId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="int_guid", type="uuid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $intGuid;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="ao_guid", type="uuid", nullable=false)
     */
    private $aoGuid;

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
     * @var int
     *
     * @ORM\Column(name="int_status", type="integer", nullable=false)
     */
    private $intStatus;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="norm_doc", type="uuid", nullable=true)
     */
    private $normDoc;

    /**
     * @var int
     *
     * @ORM\Column(name="counter", type="integer", nullable=false)
     */
    private $counter;

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return HouseInterval
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
     * Set ifnsFl
     *
     * @param string $ifnsFl
     *
     * @return HouseInterval
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
     * @return HouseInterval
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
     * @return HouseInterval
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
     * @return HouseInterval
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
     * @return HouseInterval
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
     * @return HouseInterval
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
     * @return HouseInterval
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
     * Set intStart
     *
     * @param integer $intStart
     *
     * @return HouseInterval
     */
    public function setIntStart($intStart)
    {
        $this->intStart = $intStart;

        return $this;
    }

    /**
     * Get intStart
     *
     * @return int
     */
    public function getIntStart()
    {
        return $this->intStart;
    }

    /**
     * Set intEnd
     *
     * @param integer $intEnd
     *
     * @return HouseInterval
     */
    public function setIntEnd($intEnd)
    {
        $this->intEnd = $intEnd;

        return $this;
    }

    /**
     * Get intEnd
     *
     * @return int
     */
    public function getIntEnd()
    {
        return $this->intEnd;
    }

    /**
     * Set houseIntId
     *
     * @param Uuid $houseIntId
     *
     * @return HouseInterval
     */
    public function setHouseIntId($houseIntId)
    {
        $this->houseIntId = $houseIntId;

        return $this;
    }

    /**
     * Get houseIntId
     *
     * @return Uuid
     */
    public function getHouseIntId()
    {
        return $this->houseIntId;
    }

    /**
     * Set intGuid
     *
     * @param Uuid $intGuid
     *
     * @return HouseInterval
     */
    public function setIntGuid($intGuid)
    {
        $this->intGuid = $intGuid;

        return $this;
    }

    /**
     * Get intGuid
     *
     * @return Uuid
     */
    public function getIntGuid()
    {
        return $this->intGuid;
    }

    /**
     * Set aoGuid
     *
     * @param Uuid $aoGuid
     *
     * @return HouseInterval
     */
    public function setAoGuid($aoGuid)
    {
        $this->aoGuid = $aoGuid;

        return $this;
    }

    /**
     * Get aoGuid
     *
     * @return Uuid
     */
    public function getAoGuid()
    {
        return $this->aoGuid;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return HouseInterval
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
     * @return HouseInterval
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
     * Set intStatus
     *
     * @param integer $intStatus
     *
     * @return HouseInterval
     */
    public function setIntStatus($intStatus)
    {
        $this->intStatus = $intStatus;

        return $this;
    }

    /**
     * Get intStatus
     *
     * @return int
     */
    public function getIntStatus()
    {
        return $this->intStatus;
    }

    /**
     * Set normDoc
     *
     * @param Uuid $normDoc
     *
     * @return HouseInterval
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
     * Set counter
     *
     * @param integer $counter
     *
     * @return HouseInterval
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Get counter
     *
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }
}

