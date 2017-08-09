<?php
namespace Shiptor\Bundle\FiasBundle\Subscriber\RpcServer;

use Moriony\RpcServer\Event\ExceptionEvent;
use Moriony\RpcServer\Exception\RpcException;
use Psr\Log\LoggerInterface;
use Moriony\RpcServer\Server\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExceptionLogSubscriber
 */
class ExceptionLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event)
    {
        if ($event->getException() instanceof RpcException) {
            return;
        }

        $this->logger->error($event->getException()->getMessage(), [
            'exception' => $event->getException(),
        ]);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::EVENT_RPC_EXCEPTION => [['onException']],
        ];
    }
}
