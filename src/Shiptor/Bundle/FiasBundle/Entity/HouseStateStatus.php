<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HouseStateStatus
 *
 * @ORM\Table(name="fias.house_state_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\HouseStateStatusRepository")
 */
class HouseStateStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="house_st_id", type="integer")
     * @ORM\Id
     */
    private $houseStId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     */
    private $name;

    /**
     * Set id
     *
     * @param string $houseStId
     *
     * @return HouseStateStatus
     */
    public function setHouseStId($houseStId)
    {
        $this->houseStId = $houseStId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getHouseStId()
    {
        return $this->houseStId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return HouseStateStatus
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
}

