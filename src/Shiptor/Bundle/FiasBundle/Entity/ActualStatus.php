<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActualStatus
 *
 * @ORM\Table(name="fias.actual_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\ActualStatusRepository")
 */
class ActualStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="act_stat_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $actStatId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * Set id
     *
     * @param string $actStatId
     *
     * @return ActualStatus
     */
    public function setActStatId($actStatId)
    {
        $this->actStatId = $actStatId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getActStatId()
    {
        return $this->actStatId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ActualStatus
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

