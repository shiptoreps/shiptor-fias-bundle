<?php
namespace Shiptor\Bundle\FiasBundle\Command;

use Shiptor\Bundle\FiasBundle\AbstractCommand;
use Shiptor\Bundle\FiasBundle\Entity\ActualStatus;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Shiptor\Bundle\FiasBundle\Entity\CenterStatus;
use Shiptor\Bundle\FiasBundle\Entity\CurrentStatus;
use Shiptor\Bundle\FiasBundle\Entity\EstateStatus;
use Shiptor\Bundle\FiasBundle\Entity\House;
use Shiptor\Bundle\FiasBundle\Entity\HouseInterval;
use Shiptor\Bundle\FiasBundle\Entity\HouseStateStatus;
use Shiptor\Bundle\FiasBundle\Entity\IntervalStatus;
use Shiptor\Bundle\FiasBundle\Entity\Landmark;
use Shiptor\Bundle\FiasBundle\Entity\NormativeDocument;
use Shiptor\Bundle\FiasBundle\Entity\OperationStatus;
use Shiptor\Bundle\FiasBundle\Entity\Room;
use Shiptor\Bundle\FiasBundle\Entity\Stead;
use Shiptor\Bundle\FiasBundle\Entity\StructureStatus;
use Shiptor\Bundle\FiasBundle\Serializer\Converters\AttributeConverter;
use Shiptor\Bundle\FiasBundle\Serializer\Normalizers\DateTimeNormalizer;
use Shiptor\Bundle\FiasBundle\Service\FiasService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use XMLReader;

/**
 * Class InstallCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class InstallCommand extends AbstractCommand
{
    const DIR_NAME = 'fias';
    const FIAS_FULL_DB_DIR = 'fias_dbf';
    const FIAS_FULL_DB_FILE = 'fias_dbf.rar';
    const FIAS_FULL_DB_URL = 'http://fias.nalog.ru/Public/Downloads/Actual/fias_xml.rar';

    private $transformersClasses = [
        'ACTSTAT'  => ['ActualStatus' => ActualStatus::class],
        'ADDROBJ'  => ['Object' => AddressObject::class],
        'CENTERST' => ['CenterStatus' => CenterStatus::class],
        'CURENTST' => ['CurrentStatus' => CurrentStatus::class],
        'ESTSTAT'  => ['EstateStatus' => EstateStatus::class],
        'HOUSE'    => ['House' => House::class],
        'HOUSEINT' => ['HouseInterval' => HouseInterval::class],
        'HSTSTAT'  => ['HouseStateStatus' => HouseStateStatus::class],
        'INTVSTAT' => ['IntervalStatus' => IntervalStatus::class],
        'LANDMARK' => ['Landmark' => Landmark::class],
        'NORMDOC'  => ['NormativeDocument' => NormativeDocument::class],
        'OPERSTAT' => ['OperationStatus' => OperationStatus::class],
        'ROOM'     => ['Room' => Room::class],
        'SOCRBASE' => ['AddressObjectType' => AddressObjectType::class],
        'STEAD'    => ['Stead' => Stead::class],
        'STRSTAT'  => ['StructureStatus' => StructureStatus::class],
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

        $this->getFiasService()->downloadFullArchive($dirName, self::FIAS_FULL_DB_FILE, self::FIAS_FULL_DB_URL);
        $this->getFiasService()->extractArchive($dirName, self::FIAS_FULL_DB_FILE, $dirName);

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
                            $converter = new AttributeConverter(new $class());
                            $objectNormalizer = new ObjectNormalizer(null, $converter);
                            $serializer = new Serializer([$objectNormalizer], [new XmlEncoder()]);

                            $entity = $serializer->deserialize($reader->readOuterXml(), $class, 'xml');

                            DateTimeNormalizer::normalize($entity);

                            $this->getEm()->persist($entity);

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

        return 0;
    }

    /**
     * @return FiasService
     */
    protected function getFiasService()
    {
        return $this->getContainer()->get('shiptor_fias.service.fias');
    }
}
