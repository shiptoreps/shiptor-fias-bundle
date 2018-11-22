<?php

namespace Shiptor\Bundle\FiasBundle;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractCommand extends ContainerAwareCommand
{
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getLogger()
    {
        return $this->getContainer()->get('logger');
    }
}