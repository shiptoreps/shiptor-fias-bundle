<?php
namespace Shiptor\Bundle\FiasBundle\Service;

use Shiptor\Bundle\FiasBundle\AbstractService;
use Shiptor\Bundle\FiasBundle\Serializer\Converters\AttributeConverter;
use Shiptor\Bundle\FiasBundle\Serializer\Normalizers\DateTimeNormalizer;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use XMLReader;

/**
 * Class FiasService
 * @package ShiptorFiasBundle\Service
 */
class FiasService extends AbstractService
{
    /**
     * @param $destination
     * @param $fileName
     * @param $url
     *
     * @return bool
     */
    public function downloadArchive($destination, $fileName, $url)
    {
        $this->makeDir($destination);
        try {
            file_put_contents($destination.DIRECTORY_SEPARATOR.$fileName, fopen($url, 'r'));
        } catch (\Exception $exception) {
            preg_match('/404 Not Found/', $exception->getMessage(), $match);

            if (!file_exists($destination.DIRECTORY_SEPARATOR.$fileName)) {
                @rmdir($destination);
            }

            if (!$match) {
                $this->getLogger()->addError($exception->getMessage(), ['exception' => $exception]);
            }

            return false;
        }

        return true;
    }

    /**
     * @param $rarDir
     * @param $fileName
     * @param $extractPath
     */
    public function extractArchive($rarDir, $fileName, $extractPath)
    {
        $this->makeDir($extractPath);

        $rar_file = rar_open($rarDir.DIRECTORY_SEPARATOR.$fileName);
        $list = rar_list($rar_file);

        foreach ($list as $file) {
            $file->extract($extractPath); // extract to the current dir
        }

        rar_close($rar_file);
    }

    /**
     * @param string $destination
     */
    public function makeDir($destination)
    {
        $fs = new Filesystem();

        if (!$fs->exists($destination)) {
            try {
                $fs->mkdir($destination);
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating directory at ".$exception->getPath();
            }
        }
    }

    /**
     * @param string          $scanDir
     * @param array           $transformersClasses
     * @param OutputInterface $output
     * @return bool
     *
     */
    public function saveXmlToDb($scanDir, $transformersClasses, OutputInterface $output)
    {
        $pattern = '/^AS_((DEL_)?[A-Z]+)_\d{8}_[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.XML$/';

        $files = scandir($scanDir, SCANDIR_SORT_NONE);

        foreach ($files as $file) {
            $matches = [];

            if (preg_match($pattern, $file, $matches)) {
                if (!isset($transformersClasses[$matches[1]])) {
                    $output->writeln('Have no function to process '.$file.'.');

                    continue;
                }

                $reader = new XMLReader();
                $reader->open($scanDir.DIRECTORY_SEPARATOR.$file);

                while ($reader->read()) {
                    foreach ($transformersClasses[$matches[1]] as $tag => $class) {
                        if ($reader->name === $tag && $reader->nodeType === XMLReader::ELEMENT) {
                            $converter = new AttributeConverter(new $class());
                            $objectNormalizer = new ObjectNormalizer(null, $converter);
                            $serializer = new Serializer([$objectNormalizer], [new XmlEncoder()]);

                            $entity = $serializer->deserialize($reader->readOuterXml(), $class, 'xml');

                            DateTimeNormalizer::normalize($entity);

                            $this->getEm()->merge($entity);

                            $output->writeln($tag."  -----    ".$class);

                            unset($entity);
                        }

                        unset($tag);
                        unset($class);
                    }
                }

                $this->getEm()->flush();
                $this->getEm()->clear();

                $reader->close();

                unset($reader);
            }
        }

        return true;
    }
}
