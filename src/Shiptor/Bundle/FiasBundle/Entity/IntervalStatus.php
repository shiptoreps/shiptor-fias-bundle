<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntervalStatus
 *
 * @ORM\Table(name="interval_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\IntervalStatusRepository")
 */
class IntervalStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="intv_stat_id", type="integer")
     * @ORM\Id
     */
    private $intvStatId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     */
    private $name;

    /**
     * Set id
     *
     * @param string $intvStatId
     *
     * @return IntervalStatus
     */
    public function setIntvStatId($intvStatId)
    {
        $this->intvStatId = $intvStatId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getIntvStatId()
    {
        return $this->intvStatId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return IntervalStatus
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

