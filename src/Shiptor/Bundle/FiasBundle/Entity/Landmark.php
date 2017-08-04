<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Landmark
 *
 * @ORM\Table(name="fias.landmark")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\LandmarkRepository")
 */
class Landmark
{
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=500, nullable=false)
     */
    private $location;

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
     * @var Uuid
     *
     * @ORM\Column(name="land_id", type="uuid", nullable=false)
     * @ORM\Id
     */
    private $landId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="land_guid", type="uuid", nullable=false)
     */
    private $landGuid;

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
     * Set location
     *
     * @param string $location
     *
     * @return Landmark
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * Set landId
     *
     * @param Uuid $landId
     *
     * @return Landmark
     */
    public function setLandId($landId)
    {
        $this->landId = $landId;

        return $this;
    }

    /**
     * Get landId
     *
     * @return Uuid
     */
    public function getLandId()
    {
        return $this->landId;
    }

    /**
     * Set landGuid
     *
     * @param Uuid $landGuid
     *
     * @return Landmark
     */
    public function setLandGuid($landGuid)
    {
        $this->landGuid = $landGuid;

        return $this;
    }

    /**
     * Get landGuid
     *
     * @return Uuid
     */
    public function getLandGuid()
    {
        return $this->landGuid;
    }

    /**
     * Set aoGuid
     *
     * @param Uuid $aoGuid
     *
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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
     * @return Landmark
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

