<?php

namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UpdateList
 *
 * @ORM\Table(name="fias.update_list")
 * @ORM\Entity(repositoryClass="Shiptor\Bundle\FiasBundle\Repository\UpdateListRepository")
 */
class UpdateList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="version_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $versionId;

    /**
     * @var string
     *
     * @ORM\Column(name="text_version", type="text", nullable=false)
     */
    private $textVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="fias_complete_dbf_url", type="text", nullable=false)
     */
    private $fiasCompleteDbfUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="fias_complete_xml_url", type="text", nullable=false)
     */
    private $fiasCompleteXmlUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="fias_delta_dbf_url", type="text", nullable=false)
     */
    private $fiasDeltaDbfUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="fias_delta_xml_url", type="text", nullable=false)
     */
    private $fiasDeltaXmlUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="kladr4_arj_url", type="text", nullable=false)
     */
    private $kladr4ArjUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="kladr4_7z_url", type="text", nullable=false)
     */
    private $kladr47ZUrl;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Set versionId
     *
     * @param int $versionId
     *
     * @return UpdateList
     */
    public function setVersionId($versionId)
    {
        $this->versionId = $versionId;

        return $this;
    }

    /**
     * Get versionId
     *
     * @return string
     */
    public function getVersionId()
    {
        return $this->versionId;
    }

    /**
     * Set textVersion
     *
     * @param int $textVersion
     *
     * @return UpdateList
     */
    public function setTextVersion($textVersion)
    {
        $this->textVersion = $textVersion;

        return $this;
    }

    /**
     * Get textVersion
     *
     * @return string
     */
    public function getTextVersion()
    {
        return $this->textVersion;
    }

    /**
     * Set fiasCompleteDbfUrl
     *
     * @param int $fiasCompleteDbfUrl
     *
     * @return UpdateList
     */
    public function setFiasCompleteDbfUrl($fiasCompleteDbfUrl)
    {
        $this->fiasCompleteDbfUrl = $fiasCompleteDbfUrl;

        return $this;
    }

    /**
     * Get fiasCompleteDbfUrl
     *
     * @return string
     */
    public function getFiasCompleteDbfUrl()
    {
        return $this->fiasCompleteDbfUrl;
    }

    /**
     * Set fiasCompleteXmlUrl
     *
     * @param int $fiasCompleteXmlUrl
     *
     * @return UpdateList
     */
    public function setFiasCompleteXmlUrl($fiasCompleteXmlUrl)
    {
        $this->fiasCompleteXmlUrl = $fiasCompleteXmlUrl;

        return $this;
    }

    /**
     * Get fiasCompleteXmlUrl
     *
     * @return string
     */
    public function getFiasCompleteXmlUrl()
    {
        return $this->fiasCompleteXmlUrl;
    }

    /**
     * Set fiasDeltaDbfUrl
     *
     * @param int $fiasDeltaDbfUrl
     *
     * @return UpdateList
     */
    public function setFiasDeltaDbfUrl($fiasDeltaDbfUrl)
    {
        $this->fiasDeltaDbfUrl = $fiasDeltaDbfUrl;

        return $this;
    }

    /**
     * Get fiasDeltaDbfUrl
     *
     * @return string
     */
    public function getFiasDeltaDbfUrl()
    {
        return $this->fiasDeltaDbfUrl;
    }

    /**
     * Set fiasDeltaXmlUrl
     *
     * @param int $fiasDeltaXmlUrl
     *
     * @return UpdateList
     */
    public function setFiasDeltaXmlUrl($fiasDeltaXmlUrl)
    {
        $this->fiasDeltaXmlUrl = $fiasDeltaXmlUrl;

        return $this;
    }

    /**
     * Get fiasDeltaXmlUrl
     *
     * @return string
     */
    public function getFiasDeltaXmlUrl()
    {
        return $this->fiasDeltaXmlUrl;
    }

    /**
     * Set kladr4ArjUrl
     *
     * @param int $kladr4ArjUrl
     *
     * @return UpdateList
     */
    public function setKladr4ArjUrl($kladr4ArjUrl)
    {
        $this->kladr4ArjUrl = $kladr4ArjUrl;

        return $this;
    }

    /**
     * Get kladr4ArjUrl
     *
     * @return string
     */
    public function getKladr4ArjUrl()
    {
        return $this->kladr4ArjUrl;
    }

    /**
     * Set kladr47ZUrl
     *
     * @param int $kladr47ZUrl
     *
     * @return UpdateList
     */
    public function setKladr47ZUrl($kladr47ZUrl)
    {
        $this->kladr47ZUrl = $kladr47ZUrl;

        return $this;
    }

    /**
     * Get kladr47ZUrl
     *
     * @return string
     */
    public function getKladr47ZUrl()
    {
        return $this->kladr47ZUrl;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
