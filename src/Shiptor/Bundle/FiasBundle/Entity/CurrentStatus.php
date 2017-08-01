<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrentStatus
 *
 * @ORM\Table(name="current_status")
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
    private $currentStId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @param integer $currentStId
     *
     * @return CurrentStatus
     */
    public function setCurrentStId($currentStId)
    {
        $this->currentStId = $currentStId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getCurrentStId()
    {
        return $this->currentStId;
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

