<?php
namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="log.json_rpc_response")
 * @ORM\Entity(repositoryClass="ShiptorRussiaBundle\Repository\LogJsonRpcResponseRepository")
 */
class LogJsonRpcResponse
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(name="http_code", type="text", nullable=false)
     */
    private $httpCode;
    /**
     * @ORM\Column(name="headers", type="json_array", nullable=true)
     */
    private $headers;
    /**
     * @ORM\Column(name="raw_body", type="text", nullable=false)
     */
    private $rawBody;
    /**
     * @ORM\Column(name="body", type="json_array", nullable=true)
     */
    private $body;
    /**
     * @var LogJsonRpcRequest
     *
     * @ORM\OneToOne(targetEntity="\ShiptorRussiaBundle\Entity\LogJsonRpcRequest", inversedBy="response")
     * @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     */
    private $request;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->headers = [];
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param mixed $httpCode
     * @return $this
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param mixed $rawBody
     * @return $this
     */
    public function setRawBody($rawBody)
    {
        $this->rawBody = $rawBody;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return LogJsonRpcRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param LogJsonRpcRequest $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
}
