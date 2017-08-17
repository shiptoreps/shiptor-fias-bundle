<?php
namespace Shiptor\Bundle\FiasBundle\Subscriber\RpcServer;

use Doctrine\ORM\EntityManager;
use Shiptor\Bundle\FiasBundle\Entity\LogJsonRpcRequest;
use Shiptor\Bundle\FiasBundle\Entity\LogJsonRpcResponse;
use Moriony\RpcServer\Event\HttpRequestEvent;
use Moriony\RpcServer\Event\ResponseEvent;
use Moriony\RpcServer\Server\Events;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class JsonRpcLogSubscriber
 */
class JsonRpcLogSubscriber implements EventSubscriberInterface
{
    protected $doctrine;
    protected $loggingContentMaxSize;
    /** @var LogJsonRpcRequest */
    protected $requestRecord;

    /**
     * @param RegistryInterface $doctrine
     * @param int               $loggingContentMaxSize
     */
    public function __construct(RegistryInterface $doctrine, $loggingContentMaxSize = 100000)
    {
        $this->doctrine = $doctrine;
        $this->loggingContentMaxSize = $loggingContentMaxSize;
    }

    /**
     * @param HttpRequestEvent $event
     */
    public function onHttpRequest(HttpRequestEvent $event)
    {
        /** @var EntityManager $em */
        $em = $this->doctrine->getManager();
        if (!$em->isOpen()) {
            $em = $em->create($em->getConnection(), $em->getConfiguration());
        }

        $request = $event->getRequest();
        $record = new LogJsonRpcRequest();
        $record->setUrl($request->getUri());
        $record->setMethod($request->getMethod());
        $record->setHeaders($request->headers->all());
        $loggingContent = mb_strlen($request->getContent()) >= $this->loggingContentMaxSize ? json_encode(['request is too long']) : $request->getContent();
        $record->setRawBody($loggingContent);
        if ($data = json_decode($loggingContent)) {
            $record->setBody($data);
        }
        $em->persist($record);
        $em->flush();
        $this->requestRecord = $record;
    }

    /**
     * @param ResponseEvent $event
     */
    public function onJsonRpcResponse(ResponseEvent $event)
    {
        /** @var EntityManager $em */
        $em = $this->doctrine->getManager();
        if (!$em->isOpen()) {
            $em = $em->create($em->getConnection(), $em->getConfiguration());
            $requestLogRepo = $em->getRepository('ShiptorRussiaBundle:LogJsonRpcRequest');
            $this->requestRecord = $requestLogRepo->find($this->requestRecord->getId());
        }

        $response = $event->getResponse();
        $record = new LogJsonRpcResponse();
        $record->setHeaders($response->headers->all());
        $record->setHttpCode($response->getStatusCode());
        $loggingContent = mb_strlen($response->getContent()) >= $this->loggingContentMaxSize ? json_encode(['response is too long']) : $response->getContent();
        $record->setRawBody($loggingContent);
        $record->setBody(json_decode($loggingContent));
        $record->setRequest($this->requestRecord);
        $em->persist($record);
        $em->flush();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::EVENT_HTTP_REQUEST => [['onHttpRequest']],
            Events::EVENT_RPC_RESPONSE => [['onJsonRpcResponse']],
        ];
    }
}
