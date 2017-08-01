<?php

namespace Shiptor\Bundle\FiasBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class UpdateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('shiptor:fias:update')
            ->setDescription('Get updates from fias.nalog.ru DownloadService.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|int
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }
}
