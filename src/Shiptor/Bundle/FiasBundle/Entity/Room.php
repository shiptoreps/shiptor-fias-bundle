<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(name="region_code", type="string", length=2, nullable=false)
     */
    private $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_number", type="string", length=50, nullable=false)
     */
    private $flatNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="flat_type", type="integer", nullable=false)
     */
    private $flatType;

    /**
     * @var string
     *
     * @ORM\Column(name="room_number", type="string", length=50, nullable=true)
     */
    private $roomNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="room_type", type="integer", nullable=true)
     */
    private $roomType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="date", nullable=false)
     */
    private $updateDate;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="room_id", type="uuid", nullable=false)
     */
    private $roomId;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="room_guid", type="uuid", nullable=false)
     * @ORM\Id
     */
    private $roomGuid;

    /**
     * @var Uuid
     *
     * @ORM\Column(name="house_guid", type="uuid", nullable=false)
     */
    private $houseGuid;

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
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Room
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
     * @return Room
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
     * Set flatNumber
     *
     * @param string $flatNumber
     *
     * @return Room
     */
    public function setFlatNumber($flatNumber)
    {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return string
     */
    public function getFlatNumber()
    {
        return $this->flatNumber;
    }

    /**
     * Set flatType
     *
     * @param integer $flatType
     *
     * @return Room
     */
    public function setFlatType($flatType)
    {
        $this->flatType = $flatType;

        return $this;
    }

    /**
     * Get flatType
     *
     * @return int
     */
    public function getFlatType()
    {
        return $this->flatType;
    }

    /**
     * Set roomNumber
     *
     * @param string $roomNumber
     *
     * @return Room
     */
    public function setRoomNumber($roomNumber)
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    /**
     * Get roomNumber
     *
     * @return string
     */
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }

    /**
     * Set roomType
     *
     * @param integer $roomType
     *
     * @return Room
     */
    public function setRoomType($roomType)
    {
        $this->roomType = $roomType;

        return $this;
    }

    /**
     * Get roomType
     *
     * @return int
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Room
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
     * Set roomId
     *
     * @param Uuid $roomId
     *
     * @return Room
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;

        return $this;
    }

    /**
     * Get roomId
     *
     * @return Uuid
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Set roomGuid
     *
     * @param Uuid $roomGuid
     *
     * @return Room
     */
    public function setRoomGuid($roomGuid)
    {
        $this->roomGuid = $roomGuid;

        return $this;
    }

    /**
     * Get roomGuid
     *
     * @return Uuid
     */
    public function getRoomGuid()
    {
        return $this->roomGuid;
    }

    /**
     * Set houseGuid
     *
     * @param Uuid $houseGuid
     *
     * @return Room
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Room
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
     * @return Room
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
     * @return Room
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
     * @return Room
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
     * Set liveStatus
     *
     * @param integer $liveStatus
     *
     * @return Room
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
     * @return Room
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
     * @return Room
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
}

