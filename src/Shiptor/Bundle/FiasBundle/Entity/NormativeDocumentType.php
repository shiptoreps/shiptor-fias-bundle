<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Ramsey\Uuid\Uuid;

/**
 * NormativeDocumentType
 *
 * @ORM\Table(name="fias.normative_document_type")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\NormativeDocumentTypeRepository")
 */
class NormativeDocumentType
{
    /**
     * @var Integer
     *
     * @ORM\Column(name="nd_type_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $ndTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * Set ndTypeId
     *
     * @param integer $ndTypeId
     *
     * @return $this
     */
    public function setNdTypeId($ndTypeId)
    {
        $this->ndTypeId = $ndTypeId;

        return $this;
    }

    /**
     * Get ndTypeId
     *
     * @return integer
     */
    public function getNdTypeId()
    {
        return $this->ndTypeId;
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
     * Get normDocId
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

