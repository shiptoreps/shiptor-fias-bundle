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
        $dirName = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::DIR_NAME;

        if ($this->getFiasService()->downloadArchive($dirName, self::FIAS_FULL_DB_FILE, self::FIAS_FULL_DB_URL)) {
            $this->getFiasService()->extractArchive($dirName, self::FIAS_FULL_DB_FILE, $dirName);
        }

        $this->getFiasService()->saveXmlToDb($dirName, $this->transformersClasses, $output);

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
