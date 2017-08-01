<?php

namespace Shiptor\Bundle\FiasBundle\Command;

use Shiptor\Bundle\FiasBundle\AbstractCommand;
use Shiptor\Bundle\FiasBundle\DataTransformer\ActualStatusArrayToEntityTransformer;
use Shiptor\Bundle\FiasBundle\DataTransformer\AddressObjectArrayToEntityTransformer;
use Shiptor\Bundle\FiasBundle\DataTransformer\DataTransformerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XMLReader;

/**
 * Class InstallCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class InstallCommand extends AbstractCommand
{
    const DIR_NAME = 'fias';

    private $transformersClasses = [
        'ACTSTAT' => ['ActualStatus' => ActualStatusArrayToEntityTransformer::class],
        'ADDROBJ' => ['Object' => AddressObjectArrayToEntityTransformer::class],
    ];

    private $transformers = [];

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('shiptor:fias:install')
            ->setDescription('Install fias base from fias.nalog.ru DownloadService.');
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
        $pattern = '/^AS_((DEL_)?[A-Z]+)_\d{8}_[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.XML$/';
        $dirName = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::DIR_NAME;
        $files = scandir($dirName, SCANDIR_SORT_NONE);

        foreach ($files as $file) {
            $matches = [];

            if (preg_match($pattern, $file, $matches)) {
                if (!isset($this->transformersClasses[$matches[1]])) {
                    $output->writeln('Have no function to process '.$file.'.');

                    continue;
                }

                $reader = new XMLReader();
                $reader->open($dirName.DIRECTORY_SEPARATOR.$file);

                while ($reader->read()) {
                    foreach ($this->transformersClasses[$matches[1]] as $tag => $class) {
                        if ($reader->name === $tag && $reader->nodeType === XMLReader::ELEMENT) {
                            $attributes = [];

                            if ($reader->hasAttributes) {
                                while ($reader->moveToNextAttribute()) {
                                    $attributes[$reader->name] = $reader->value;
                                }
                            }

                            if (!isset($this->transformers[$matches[1]][$tag])) {
                                $transformer = new $class();

                                if (!isset($this->transformers[$matches[1]])) {
                                    $this->transformers[$matches[1]] = [];
                                }

                                $this->transformers[$matches[1]][$tag] = $transformer;
                            }

                            /** @var DataTransformerInterface $transformer */
                            $transformer = $this->transformers[$matches[1]][$tag];
                            $entity = $transformer->transform($attributes);

                            $this->getEm()->persist($entity);
                            $this->getEm()->flush();
                            $this->getEm()->clear();

                            unset($entity);
                            unset($attributes);
                        }

                        unset($tag);
                        unset($class);
                    }
                }

                $reader->close();

                unset($reader);
            }
        }

        return 0;
    }
}
