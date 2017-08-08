<?php
namespace Shiptor\Bundle\FiasBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @property ContainerInterface $container
 */
trait ServiceTrait
{
    /**
     * @param string $id
     * @return object
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @return Registry
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getLogger()
    {
        return $this->container->get('logger');
    }
}
