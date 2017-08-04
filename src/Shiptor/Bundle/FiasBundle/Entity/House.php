<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * House
 *
 * @ORM\Table(name="fias.house")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\HouseRepository")
 */
class House
{
    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=6, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="house_num", type="string", length=20, nullable=true)
     */
    private $houseNum;
    /**
     * @var int
     *
     * @ORM\Column(name="est_status", type="integer", nullable=false)
     */
    private $estStatus;
    /**
     * @var string
     *
     * @ORM\Column(name="build_num", type="string", length=10, nullable=true)
     */
    private $buildNum;
    /**
     * @var string
     *
     * @ORM\Column(name="struc_num", type="string", length=10, nullable=true)
     */
    private $strucNum;
    /**
     * @var int
     *
     * @ORM\Column(name="str_status", type="integer", nullable=false)
     */
    private $strStatus;
    /**
     * @var Uuid
     *
     * @ORM\Column(name="house_id", type="uuid", nullable=false)
     * @ORM\Id
     */
    private $houseId;
    /**
     * @var Uuid
     *
     * @ORM\Column(name="house_guid", type="uuid", nullable=false)
     */
    private $houseGuid;
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
     * @ORM\Column(name="stat_status", type="integer", nullable=false)
     */
    private $statStatus;
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
     * @var string
     *
     * @ORM\Column(name="cad_num", type="string", length=100, nullable=true)
     */
    private $cadNum;
    /**
     * @var int
     *
     * @ORM\Column(name="div_type", type="integer", nullable=false)
     */
    private $divType;

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return House
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
     * @return House
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
     * @return House
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
     * @return House
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
     * @return House
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
     * @return House
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
     * @return House
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
     * @return House
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
     * Set houseNum
     *
     * @param string $houseNum
     *
     * @return House
     */
    public function setHouseNum($houseNum)
    {
        $this->houseNum = $houseNum;

        return $this;
    }

    /**
     * Get houseNum
     *
     * @return string
     */
    public function getHouseNum()
    {
        return $this->houseNum;
    }

    /**
     * Set estStatus
     *
     * @param integer $estStatus
     *
     * @return House
     */
    public function setEstStatus($estStatus)
    {
        $this->estStatus = $estStatus;

        return $this;
    }

    /**
     * Get estStatus
     *
     * @return int
     */
    public function getEstStatus()
    {
        return $this->estStatus;
    }

    /**
     * Set buildNum
     *
     * @param string $buildNum
     *
     * @return House
     */
    public function setBuildNum($buildNum)
    {
        $this->buildNum = $buildNum;

        return $this;
    }

    /**
     * Get buildNum
     *
     * @return string
     */
    public function getBuildNum()
    {
        return $this->buildNum;
    }

    /**
     * Set strucNum
     *
     * @param string $strucNum
     *
     * @return House
     */
    public function setStrucNum($strucNum)
    {
        $this->strucNum = $strucNum;

        return $this;
    }

    /**
     * Get strucNum
     *
     * @return string
     */
    public function getStrucNum()
    {
        return $this->strucNum;
    }

    /**
     * Set strStatus
     *
     * @param integer $strStatus
     *
     * @return House
     */
    public function setStrStatus($strStatus)
    {
        $this->strStatus = $strStatus;

        return $this;
    }

    /**
     * Get strStatus
     *
     * @return int
     */
    public function getStrStatus()
    {
        return $this->strStatus;
    }

    /**
     * Set houseId
     *
     * @param Uuid $houseId
     *
     * @return House
     */
    public function setHouseId($houseId)
    {
        $this->houseId = $houseId;

        return $this;
    }

    /**
     * Get houseId
     *
     * @return Uuid
     */
    public function getHouseId()
    {
        return $this->houseId;
    }

    /**
     * Set houseGuid
     *
     * @param Uuid $houseGuid
     *
     * @return House
     */
    public function setHouseGuid($houseGuid)
    {
        $this->houseGuid = $houseGuid;

        return $this;
    }

    /**
     * Get houseGuid
     *
     * @return Uuid
     */
    public function getHouseGuid()
    {
        return $this->houseGuid;
    }

    /**
     * Set aoGuid
     *
     * @param Uuid $aoGuid
     *
     * @return House
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
     * @return House
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
     * @return House
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
     * Set statStatus
     *
     * @param integer $statStatus
     *
     * @return House
     */
    public function setStatStatus($statStatus)
    {
        $this->statStatus = $statStatus;

        return $this;
    }

    /**
     * Get statStatus
     *
     * @return int
     */
    public function getStatStatus()
    {
        return $this->statStatus;
    }

    /**
     * Set normDoc
     *
     * @param Uuid $normDoc
     *
     * @return House
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
     * @return House
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

    /**
     * Set cadNum
     *
     * @param string $cadNum
     *
     * @return House
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
     * @return House
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
