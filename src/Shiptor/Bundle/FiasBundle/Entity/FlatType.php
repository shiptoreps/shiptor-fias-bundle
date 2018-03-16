<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="fias.flat_type")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\FlatTypeRepository")
 */
class FlatType
{
    /**
     * @var int
     * @ORM\Id
     *
     * @ORM\Column(name="fl_type_id", type="integer", nullable=false)
     */
    private $flTypeId;

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
     * Set flTypeId
     *
     * @param integer $flTypeId
     *
     * @return $this
     */
    public function setFlTypeId($flTypeId)
    {
        $this->flTypeId = $flTypeId;

        return $this;
    }

    /**
     * Get flTypeId
     *
     * @return integer
     */
    public function getFlTypeId()
    {
        return $this->flTypeId;
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
