<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrentStatus
 *
 * @ORM\Table(name="fias.current_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\CurrentStatusRepository")
 */
class CurrentStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="current_st_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $curentStId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @param integer $curentStId
     *
     * @return CurrentStatus
     */
    public function setCurentStId($curentStId)
    {
        $this->curentStId = $curentStId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getCurentStId()
    {
        return $this->curentStId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CurrentStatus
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

