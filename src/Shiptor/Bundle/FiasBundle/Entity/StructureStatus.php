<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StructureStatus
 *
 * @ORM\Table(name="fias.structure_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\StructureStatusRepository")
 */
class StructureStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="str_stat_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $strStatId;

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
     * @param string $strStatId
     *
     * @return StructureStatus
     */
    public function setStrStatId($strStatId)
    {
        $this->strStatId = $strStatId;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getStrStatId()
    {
        return $this->strStatId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return StructureStatus
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
     * @return StructureStatus
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

