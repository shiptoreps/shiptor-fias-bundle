<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * NormativeDocument
 *
 * @ORM\Table(name="normative_document")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\NormativeDocumentRepository")
 */
class NormativeDocument
{
    /**
     * @var Uuid
     *
     * @ORM\Column(name="norm_doc_id", type="uuid", nullable=false)
     * @ORM\Id
     */
    private $normDocId;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_name", type="text", nullable=true)
     */
    private $docName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="doc_date", type="date", nullable=true)
     */
    private $docDate;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_num", type="string", length=20, nullable=true)
     */
    private $docNum;

    /**
     * @var int
     *
     * @ORM\Column(name="doc_type", type="integer", nullable=false)
     */
    private $docType;

    /**
     * @var int
     *
     * @ORM\Column(name="doc_img_id", type="integer", nullable=true)
     */
    private $docImgId;

    /**
     * Set normDocId
     *
     * @param Uuid $normDocId
     *
     * @return NormativeDocument
     */
    public function setNormDocId($normDocId)
    {
        $this->normDocId = $normDocId;

        return $this;
    }

    /**
     * Get normDocId
     *
     * @return Uuid
     */
    public function getNormDocId()
    {
        return $this->normDocId;
    }

    /**
     * Set docName
     *
     * @param string $docName
     *
     * @return NormativeDocument
     */
    public function setDocName($docName)
    {
        $this->docName = $docName;

        return $this;
    }

    /**
     * Get docName
     *
     * @return string
     */
    public function getDocName()
    {
        return $this->docName;
    }

    /**
     * Set docDate
     *
     * @param \DateTime $docDate
     *
     * @return NormativeDocument
     */
    public function setDocDate($docDate)
    {
        $this->docDate = $docDate;

        return $this;
    }

    /**
     * Get docDate
     *
     * @return \DateTime
     */
    public function getDocDate()
    {
        return $this->docDate;
    }

    /**
     * Set docNum
     *
     * @param string $docNum
     *
     * @return NormativeDocument
     */
    public function setDocNum($docNum)
    {
        $this->docNum = $docNum;

        return $this;
    }

    /**
     * Get docNum
     *
     * @return string
     */
    public function getDocNum()
    {
        return $this->docNum;
    }

    /**
     * Set docType
     *
     * @param integer $docType
     *
     * @return NormativeDocument
     */
    public function setDocType($docType)
    {
        $this->docType = $docType;

        return $this;
    }

    /**
     * Get docType
     *
     * @return int
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * Set docImgId
     *
     * @param integer $docImgId
     *
     * @return NormativeDocument
     */
    public function setDocImgId($docImgId)
    {
        $this->docImgId = $docImgId;

        return $this;
    }

    /**
     * Get docImgId
     *
     * @return int
     */
    public function getDocImgId()
    {
        return $this->docImgId;
    }
}

