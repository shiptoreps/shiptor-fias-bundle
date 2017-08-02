<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationStatus
 *
 * @ORM\Table(name="fias.operation_status")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\OperationStatusRepository")
 */
class OperationStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="oper_stat_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $operStatId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * Set id
     *
     * @param string $operStatId
     *
     * @return OperationStatus
     */
    public function setOperStatId($operStatId)
    {
        $this->operStatId = $operStatId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getOperStatId()
    {
        return $this->operStatId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return OperationStatus
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

