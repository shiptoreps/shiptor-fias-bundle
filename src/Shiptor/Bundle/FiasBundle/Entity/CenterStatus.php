<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CenterStatus
 *
 * @ORM\Table(name="fias.center_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\CenterStatusRepository")
 */
class CenterStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="center_st_id", type="integer")
     * @ORM\Id
     */
    private $centerStId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * Set id
     *
     * @param string $centerStId
     *
     * @return CenterStatus
     */
    public function setCenterStId($centerStId)
    {
        $this->centerStId = $centerStId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getCenterStId()
    {
        return $this->centerStId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CenterStatus
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

