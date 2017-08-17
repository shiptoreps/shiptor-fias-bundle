<?php
namespace Shiptor\Bundle\FiasBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Service
 */
abstract class AbstractService
{
    use ServiceTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
