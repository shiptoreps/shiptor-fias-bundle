<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddressObjectType
 *
 * @ORM\Table(name="address_object_type")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\AddressObjectTypeRepository")
 */
class AddressObjectType
{
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="sc_name", type="string", length=10, nullable=true)
     */
    private $scName;

    /**
     * @var string
     *
     * @ORM\Column(name="socr_name", type="string", length=50, nullable=false)
     */
    private $socrName;

    /**
     * @var string
     *
     * @ORM\Column(name="kod_ts_t", type="string", length=4, nullable=false)
     * @ORM\Id
     */
    private $kodTsT;

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return AddressObjectType
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set scName
     *
     * @param string $scName
     *
     * @return AddressObjectType
     */
    public function setScName($scName)
    {
        $this->scName = $scName;

        return $this;
    }

    /**
     * Get scName
     *
     * @return string
     */
    public function getScName()
    {
        return $this->scName;
    }

    /**
     * Set socrName
     *
     * @param string $socrName
     *
     * @return AddressObjectType
     */
    public function setSocrName($socrName)
    {
        $this->socrName = $socrName;

        return $this;
    }

    /**
     * Get socrName
     *
     * @return string
     */
    public function getSocrName()
    {
        return $this->socrName;
    }

    /**
     * Set kodTsT
     *
     * @param string $kodTsT
     *
     * @return AddressObjectType
     */
    public function setKodTsT($kodTsT)
    {
        $this->kodTsT = $kodTsT;

        return $this;
    }

    /**
     * Get kodTsT
     *
     * @return string
     */
    public function getKodTsT()
    {
        return $this->kodTsT;
    }
}

