<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Room
 *
 * @ORM\Table(name="fias.room_type")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\RoomTypeRepository")
 */
class RoomType
{
    /**
     * @var int
     * @ORM\Id
     *
     * @ORM\Column(name="rm_type_id", type="integer", nullable=false)
     */
    private $rmTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", nullable=true)
     */
    private $shortName;

    /**
     * Set rmTypeId
     *
     * @param integer $rmTypeId
     *
     * @return $this
     */
    public function setRmTypeId($rmTypeId)
    {
        $this->rmTypeId = $rmTypeId;

        return $this;
    }

    /**
     * Get rmTypeId
     *
     * @return integer
     */
    public function getRmTypeId()
    {
        return $this->rmTypeId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
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
     * Set shortName
     *
     * @param string $shortName
     *
     * @return $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }
}
