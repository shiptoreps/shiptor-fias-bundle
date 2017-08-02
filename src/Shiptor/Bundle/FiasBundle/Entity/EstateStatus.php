<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstateStatus
 *
 * @ORM\Table(name="fias.estate_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\EstateStatusRepository")
 */
class EstateStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="est_stat_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $estStatId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=20, nullable=true)
     */
    private $shortName;

    /**
     * Set id
     *
     * @param string $estStatId
     *
     * @return EstateStatus
     */
    public function setEstStatId($estStatId)
    {
        $this->estStatId = $estStatId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getEstStatId()
    {
        return $this->estStatId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EstateStatus
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
     * @return EstateStatus
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

