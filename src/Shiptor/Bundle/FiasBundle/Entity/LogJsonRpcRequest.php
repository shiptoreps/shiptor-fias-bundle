<?php
namespace Shiptor\Bundle\FiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="log.json_rpc_request")
 * @ORM\Entity(repositoryClass="ShiptorRussiaBundle\Repository\LogJsonRpcRequestRepository")
 */
class LogJsonRpcRequest
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
     * @ORM\Column(name="url", type="text", nullable=false)
     */
    private $url;
    /**
     * @ORM\Column(name="method", type="text", nullable=false)
     */
    private $method;
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
     * @var LogJsonRpcResponse
     *
     * @ORM\OneToOne(targetEntity="\ShiptorRussiaBundle\Entity\LogJsonRpcResponse", mappedBy="request")
     */
    private $response;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

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
     * @return LogJsonRpcResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param LogJsonRpcRequest $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}
