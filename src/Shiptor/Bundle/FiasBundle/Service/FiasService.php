<?php
namespace Shiptor\Bundle\FiasBundle\Service;

use Shiptor\Bundle\FiasBundle\AbstractService;
use Shiptor\Bundle\FiasBundle\DataTransformer\AddressObjectTypeUpsertTransformer;
use Shiptor\Bundle\FiasBundle\DataTransformer\AddressObjectUpsertTransformer;
use Shiptor\Bundle\FiasBundle\DataTransformer\DataTransformerInterface;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Shiptor\Bundle\FiasBundle\Serializer\Converters\AttributeConverter;
use Shiptor\Bundle\FiasBundle\Serializer\Normalizers\DateTimeNormalizer;
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
    const CLEAR_DB = 'clear';
    const FILL_DB = 'fill';


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
     * @param string $scanDir
     * @param array  $transformersClasses
     * @param string  $action
     *
     * @return bool
     */
    public function xmlDbHandler($scanDir, $transformersClasses, $action)
    {
        $pattern = '/^AS_((DEL_)?[A-Z]+)_\d{8}_[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.XML$/';

        $files = scandir($scanDir, SCANDIR_SORT_ASCENDING);

        $counter = 1;
        $divisor = 20000;

        foreach ($files as $file) {
            $matches = [];

            if (preg_match($pattern, $file, $matches)) {
                if (!isset($transformersClasses[$matches[1]])) {
                    echo 'Have no function to process '.$file.'.'.PHP_EOL;

                    continue;
                }

                echo 'Processing to parse file: '.$file.PHP_EOL;

                $class = current($transformersClasses[$matches[1]]);
                $tag = key($transformersClasses[$matches[1]]);

                $converter = new AttributeConverter(new $class());
                $objectNormalizer = new ObjectNormalizer(null, $converter);
                $serializer = new Serializer([$objectNormalizer], [new XmlEncoder()]);

                $reader = new XMLReader();
                $reader->open($scanDir.DIRECTORY_SEPARATOR.$file);

                while ($reader->read()) {
                    if ($reader->name === $tag && $reader->nodeType === XMLReader::ELEMENT) {
                        $entity = $serializer->deserialize($reader->readOuterXml(), $class, 'xml');

                        DateTimeNormalizer::normalize($entity);

                        if (self::FILL_DB === $action) {
                            $counter = $this->fillDatabase($entity, $counter, $divisor);
                        }

                        if (self::CLEAR_DB === $action) {
                            $counter = $this->clearDatabase($entity, $counter, $divisor);
                        }

                        if ($counter % $divisor == 0) {
                            echo $tag." --- ".$class." -- ".$counter.PHP_EOL;
                        }

                        unset($entity);
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

    /**
     * @param mixed                    $entity
     * @param DataTransformerInterface $transformer
     *
     * @return int
     */
    public function upsert($entity, DataTransformerInterface $transformer)
    {
        $data = $transformer->transform($entity);

        $metadata = $this->getEm()->getClassMetadata(get_class($entity));
        $table = $metadata->getSchemaName().'.'.$metadata->getTableName();
        $identifier = [
            key($data) => current($data),
        ];

        if (!($result = $this->getEm()->getConnection()->update($table, $data, $identifier))) {
            $result = $this->getEm()->getConnection()->insert($table, $data);
        }

        if (!$result) {
            $this->getLogger()->addError('Could not upsert!', ['exception' => $data]);
        }

        return $result;
    }

    /**
     * @param mixed   $entity
     * @param integer $counter
     * @param integer $divisor
     * @return integer
     */
    public function fillDatabase($entity, $counter, $divisor)
    {
        try {
            if ($entity instanceof AddressObject) {
                $transformer = new AddressObjectUpsertTransformer();

                $this->upsert($entity, $transformer);
            } elseif ($entity instanceof AddressObjectType) {
                $transformer = new AddressObjectTypeUpsertTransformer();

                $this->upsert($entity, $transformer);
            } else {
                $this->getEm()->merge($entity);

                if ($counter % $divisor  == 0) {
                    $this->getEm()->flush();
                    $this->getEm()->clear();
                }
            }

            $counter++;
        } catch (\Exception $exception) {
            $this->getLogger()->addError($exception->getMessage(), ['exception' => $exception]);
        }

        return $counter;
    }

    /**
     * @param mixed   $entity
     * @param integer $counter
     * @param integer $divisor
     * @return integer
     */
    public function clearDatabase($entity, $counter, $divisor)
    {
        try {
            $metadata = $this->getEm()->getClassMetadata(get_class($entity));
            $entity = $this->getEm()->getRepository(get_class($entity))->findOneBy($metadata->getIdentifierValues($entity));

            if ($entity) {
                $this->getEm()->remove($entity);

                $counter++;
            }

            if ($counter % $divisor  == 0) {
                $this->getEm()->flush();
            }
        } catch (\Exception $exception) {
            $this->getLogger()->addError($exception->getMessage(), ['exception' => $exception]);
        }

        return $counter;
    }
}
