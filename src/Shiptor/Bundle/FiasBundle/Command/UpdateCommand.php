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
use Shiptor\Bundle\FiasBundle\Entity\UpdateList;
use Shiptor\Bundle\FiasBundle\Service\FiasService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class UpdateCommand extends AbstractCommand
{
    const FIAS_UPDATE_DIR = 'fias_updates'.DIRECTORY_SEPARATOR.'fias_update_';
    const FILE_EXTENTION = '.rar';
    const FIAS_UPDATE_FILE = 'fias_updat_';

    private $transformersClasses = [
//        'ACTSTAT'  => ['ActualStatus' => ActualStatus::class],
//        'ADDROBJ'  => ['Object' => AddressObject::class],
//        'CENTERST' => ['CenterStatus' => CenterStatus::class],
//        'CURENTST' => ['CurrentStatus' => CurrentStatus::class],
//        'ESTSTAT'  => ['EstateStatus' => EstateStatus::class],
//        'HOUSE'    => ['House' => House::class],
//        'HOUSEINT' => ['HouseInterval' => HouseInterval::class],
//        'HSTSTAT'  => ['HouseStateStatus' => HouseStateStatus::class],
//        'INTVSTAT' => ['IntervalStatus' => IntervalStatus::class],
        'LANDMARK' => ['Landmark' => Landmark::class],
        'NORMDOC'  => ['NormativeDocument' => NormativeDocument::class],
        'OPERSTAT' => ['OperationStatus' => OperationStatus::class],
        'ROOM'     => ['Room' => Room::class],
        'SOCRBASE' => ['AddressObjectType' => AddressObjectType::class],
        'STEAD'    => ['Stead' => Stead::class],
        'STRSTAT'  => ['StructureStatus' => StructureStatus::class],
    ];

    protected function configure()
    {
        $this
            ->setName('shiptor:fias:update')
            ->addArgument('version', InputArgument::OPTIONAL, 'Version of update:')
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

        $version = $input->getArgument('version');
        /** @var UpdateList[] $updateList */
        $updateList = $this->getEm()
            ->getRepository('ShiptorFiasBundle:UpdateList')
            ->getUpdateList($version)
            ->getQuery()
            ->getResult()
        ;

        foreach ($updateList as $item) {
            $dirName = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::FIAS_UPDATE_DIR.$item->getVersionId();
            $fileName = self::FIAS_UPDATE_FILE.$item->getVersionId().self::FILE_EXTENTION;

            if ($this->getFiasService()->downloadFullArchive($dirName, $fileName, $item->getFiasDeltaXmlUrl())) {
                $this->getFiasService()->extractArchive($dirName, $fileName, $dirName);
            }

            $this->getFiasService()->saveXmlToDb($dirName, $this->transformersClasses, $output);
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
