<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * AddressObject
 *
 * @ORM\Table(name="fias.address_object")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\AddressObjectRepository")
 */
class AddressObject
{
    const STATUS_NOT_ACTUAL = 0;
    const STATUS_ACTUAL = 1;

    const DIV_TYPE_RANGE = [0, 1, 2];

    /**
     * @var string
     *
     * @ORM\Column(name="formal_name", type="string", length=120, nullable=false)
     */
    private $formalName;

    /**
     * @var string
     *
     * @ORM\Column(name="region_code", type="string", length=2, nullable=false)
     */
    private $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="auto_code", type="string", length=1, nullable=false)
     */
    private $autoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="area_code", type="string", length=3, nullable=false)
     */
    private $areaCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city_code", type="string", length=3, nullable=false)
     */
    private $cityCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ct_ar_code", type="string", length=3, nullable=false)
     */
    private $ctArCode;

    /**
     * @var string
     *
     * @ORM\Column(name="place_code", type="string", length=3, nullable=false)
     */
    private $placeCode;

    /**
     * @var string
     *
     * @ORM\Column(name="street_code", type="string", length=4, nullable=false)
     */
    private $streetCode;

    /**
     * @var string
     *
     * @ORM\Column(name="extr_code", type="string", length=4, nullable=false)
     */
    private $extrCode;

    /**
     * @var string
     *
     * @ORM\Column(name="s_ext_code", type="string", length=3, nullable=false)
     */
    private $sExtCode;

    /**
     * @var string
     *
     * @ORM\Column(name="off_name", type="string", length=120, nullable=true)
     */
    private $offName;

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
     * @var AddressObjectType
     *
     * @ORM\ManyToOne(targetEntity="AddressObjectType")
     * @ORM\JoinColumn(name="short_name", referencedColumnName="sc_name", nullable=false)
     */
    private $shortName;

    /**
     * @var integer
     *
     * @ORM\Column(name="ao_level", type="integer", nullable=false)
     */
    private $aoLevel;

    /**
     * @var Uuid
     * @ORM\Column(name="ao_guid", type="uuid", nullable=false)
     */
    private $aoGuid;

    /**
     * @var Uuid
     * @ORM\Column(name="parent_guid", type="uuid", nullable=false)
     */
    private $parentGuid;

    /**
     * @var Uuid
     *
     * @ORM\Id
     * @ORM\Column(name="ao_id", type="uuid", nullable=false)
     */
    private $aoId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="prev_id", type="uuid", nullable=true)
     */
    private $prevId;

    /**
     * @var AddressObject
     *
     * @ORM\ManyToOne(targetEntity="AddressObject", inversedBy="aoId")
     * @ORM\JoinColumn(name="next_id", referencedColumnName="ao_id", nullable=true)
     */
    private $nextId;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=17, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="plain_code", type="string", length=15, nullable=true)
     */
    private $plainCode;

    /**
     * @var int
     *
     * @ORM\Column(name="act_status", type="integer", nullable=false)
     */
    private $actStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="cent_status", type="integer", nullable=false)
     */
    private $centStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="oper_status", type="integer", nullable=false)
     */
    private $operStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="curr_status", type="integer", nullable=false)
     */
    private $currStatus;

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
     * @ORM\Column(name="norm_doc", type="uuid", nullable=true)
     */
    private $normDoc;

    /**
     * @var int
     *
     * @ORM\Column(name="live_status", type="integer", nullable=false)
     */
    private $liveStatus;

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
     * Set aoGuid
     *
     * @param Uuid $aoGuid
     *
     * @return AddressObject
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
     * Set formalName
     *
     * @param string $formalName
     *
     * @return AddressObject
     */
    public function setFormalName($formalName)
    {
        $this->formalName = $formalName;

        return $this;
    }

    /**
     * Get formalName
     *
     * @return string
     */
    public function getFormalName()
    {
        return $this->formalName;
    }

    /**
     * Set regionCode
     *
     * @param string $regionCode
     *
     * @return AddressObject
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
     * Set autoCode
     *
     * @param string $autoCode
     *
     * @return AddressObject
     */
    public function setAutoCode($autoCode)
    {
        $this->autoCode = $autoCode;

        return $this;
    }

    /**
     * Get autoCode
     *
     * @return string
     */
    public function getAutoCode()
    {
        return $this->autoCode;
    }

    /**
     * Set areaCode
     *
     * @param string $areaCode
     *
     * @return AddressObject
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    /**
     * Get areaCode
     *
     * @return string
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set cityCode
     *
     * @param string $cityCode
     *
     * @return AddressObject
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set ctArCode
     *
     * @param string $ctArCode
     *
     * @return AddressObject
     */
    public function setCtArCode($ctArCode)
    {
        $this->ctArCode = $ctArCode;

        return $this;
    }

    /**
     * Get ctArCode
     *
     * @return string
     */
    public function getCtArCode()
    {
        return $this->ctArCode;
    }

    /**
     * Set placeCode
     *
     * @param string $placeCode
     *
     * @return AddressObject
     */
    public function setPlaceCode($placeCode)
    {
        $this->placeCode = $placeCode;

        return $this;
    }

    /**
     * Get placeCode
     *
     * @return string
     */
    public function getPlaceCode()
    {
        return $this->placeCode;
    }

    /**
     * Set streetCode
     *
     * @param string $streetCode
     *
     * @return AddressObject
     */
    public function setStreetCode($streetCode)
    {
        $this->streetCode = $streetCode;

        return $this;
    }

    /**
     * Get streetCode
     *
     * @return string
     */
    public function getStreetCode()
    {
        return $this->streetCode;
    }

    /**
     * Set extrCode
     *
     * @param string $extrCode
     *
     * @return AddressObject
     */
    public function setExtrCode($extrCode)
    {
        $this->extrCode = $extrCode;

        return $this;
    }

    /**
     * Get extrCode
     *
     * @return string
     */
    public function getExtrCode()
    {
        return $this->extrCode;
    }

    /**
     * Set sExtCode
     *
     * @param string $sExtCode
     *
     * @return AddressObject
     */
    public function setSExtCode($sExtCode)
    {
        $this->sExtCode = $sExtCode;

        return $this;
    }

    /**
     * Get sExtCode
     *
     * @return string
     */
    public function getSExtCode()
    {
        return $this->sExtCode;
    }

    /**
     * Set offName
     *
     * @param string $offName
     *
     * @return AddressObject
     */
    public function setOffName($offName)
    {
        $this->offName = $offName;

        return $this;
    }

    /**
     * Get offName
     *
     * @return string
     */
    public function getOffName()
    {
        return $this->offName;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * @return AddressObject
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
     * Set shortName
     *
     * @param AddressObjectType $shortName
     *
     * @return AddressObject
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return AddressObjectType
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set aoLevel
     *
     * @param integer $aoLevel
     *
     * @return AddressObject
     */
    public function setAoLevel($aoLevel)
    {
        $this->aoLevel = $aoLevel;

        return $this;
    }

    /**
     * Get aoLevel
     *
     * @return int
     */
    public function getAoLevel()
    {
        return $this->aoLevel;
    }

    /**
     * Set parentGuid
     *
     * @param Uuid $parentGuid
     *
     * @return AddressObject
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
     * Set aoId
     *
     * @param Uuid $aoId
     *
     * @return AddressObject
     */
    public function setAoId($aoId)
    {
        $this->aoId = $aoId;

        return $this;
    }

    /**
     * Get aoId
     *
     * @return Uuid
     */
    public function getAoId()
    {
        return $this->aoId;
    }

    /**
     * Set prevId
     *
     * @param Uuid $prevId
     *
     * @return AddressObject
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
     * @param AddressObject|null $nextId
     *
     * @return AddressObject
     */
    public function setNextId($nextId)
    {
        $this->nextId = $nextId;

        return $this;
    }

    /**
     * Get nextId
     *
     * @return AddressObject|null
     */
    public function getNextId()
    {
        return $this->nextId;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return AddressObject
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
     * Set plainCode
     *
     * @param string $plainCode
     *
     * @return AddressObject
     */
    public function setPlainCode($plainCode)
    {
        $this->plainCode = $plainCode;

        return $this;
    }

    /**
     * Get plainCode
     *
     * @return string
     */
    public function getPlainCode()
    {
        return $this->plainCode;
    }

    /**
     * Set actStatus
     *
     * @param integer $actStatus
     *
     * @return AddressObject
     */
    public function setActStatus($actStatus)
    {
        $this->actStatus = $actStatus;

        return $this;
    }

    /**
     * Get actStatus
     *
     * @return int
     */
    public function getActStatus()
    {
        return $this->actStatus;
    }

    /**
     * Set centStatus
     *
     * @param integer $centStatus
     *
     * @return AddressObject
     */
    public function setCentStatus($centStatus)
    {
        $this->centStatus = $centStatus;

        return $this;
    }

    /**
     * Get centStatus
     *
     * @return int
     */
    public function getCentStatus()
    {
        return $this->centStatus;
    }

    /**
     * Set operStatus
     *
     * @param integer $operStatus
     *
     * @return AddressObject
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
     * Set currStatus
     *
     * @param integer $currStatus
     *
     * @return AddressObject
     */
    public function setCurrStatus($currStatus)
    {
        $this->currStatus = $currStatus;

        return $this;
    }

    /**
     * Get currStatus
     *
     * @return int
     */
    public function getCurrStatus()
    {
        return $this->currStatus;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return AddressObject
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
     * @return AddressObject
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
     * Set normDoc
     *
     * @param Uuid $normDoc
     *
     * @return AddressObject
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
     * Set liveStatus
     *
     * @param integer $liveStatus
     *
     * @return AddressObject
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
     * Set cadNum
     *
     * @param string $cadNum
     *
     * @return AddressObject
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
     * @return AddressObject
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

