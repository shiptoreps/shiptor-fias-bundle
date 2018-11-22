<?php
namespace Shiptor\Bundle\FiasBundle\Command;

use Shiptor\Bundle\FiasBundle\AbstractCommand;
use Shiptor\Bundle\FiasBundle\Entity\ActualStatus;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Shiptor\Bundle\FiasBundle\Entity\CenterStatus;
use Shiptor\Bundle\FiasBundle\Entity\CurrentStatus;
use Shiptor\Bundle\FiasBundle\Entity\EstateStatus;
use Shiptor\Bundle\FiasBundle\Entity\FlatType;
use Shiptor\Bundle\FiasBundle\Entity\House;
use Shiptor\Bundle\FiasBundle\Entity\HouseInterval;
use Shiptor\Bundle\FiasBundle\Entity\HouseStateStatus;
use Shiptor\Bundle\FiasBundle\Entity\IntervalStatus;
use Shiptor\Bundle\FiasBundle\Entity\Landmark;
use Shiptor\Bundle\FiasBundle\Entity\NormativeDocument;
use Shiptor\Bundle\FiasBundle\Entity\NormativeDocumentType;
use Shiptor\Bundle\FiasBundle\Entity\OperationStatus;
use Shiptor\Bundle\FiasBundle\Entity\Room;
use Shiptor\Bundle\FiasBundle\Entity\RoomType;
use Shiptor\Bundle\FiasBundle\Entity\Stead;
use Shiptor\Bundle\FiasBundle\Entity\StructureStatus;
use Shiptor\Bundle\FiasBundle\Entity\UpdateList;
use Shiptor\Bundle\FiasBundle\Service\FiasService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        'ACTSTAT'  => ['ActualStatus' => ActualStatus::class],
        'SOCRBASE' => ['AddressObjectType' => AddressObjectType::class],
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
        'NDOCTYPE' => ['NormativeDocumentType' => NormativeDocumentType::class],
        'OPERSTAT' => ['OperationStatus' => OperationStatus::class],
        'ROOM'     => ['Room' => Room::class],
        'ROOMTYPE' => ['RoomType' => RoomType::class],
        'FLATTYPE' => ['FlatType' => FlatType::class],
        'STEAD'    => ['Stead' => Stead::class],
        'STRSTAT'  => ['StructureStatus' => StructureStatus::class],
    ];

    private $deleteDataClasses = [
        'DEL_ACTSTAT'  => ['ActualStatus' => ActualStatus::class],
        'DEL_ADDROBJ'  => ['Object' => AddressObject::class],
        'DEL_CENTERST' => ['CenterStatus' => CenterStatus::class],
        'DEL_CURENTST' => ['CurrentStatus' => CurrentStatus::class],
        'DEL_ESTSTAT'  => ['EstateStatus' => EstateStatus::class],
        'DEL_HOUSE'    => ['House' => House::class],
        'DEL_HOUSEINT' => ['HouseInterval' => HouseInterval::class],
        'DEL_HSTSTAT'  => ['HouseStateStatus' => HouseStateStatus::class],
        'DEL_INTVSTAT' => ['IntervalStatus' => IntervalStatus::class],
        'DEL_LANDMARK' => ['Landmark' => Landmark::class],
        'DEL_NORMDOC'  => ['NormativeDocument' => NormativeDocument::class],
        'DEL_OPERSTAT' => ['OperationStatus' => OperationStatus::class],
        'DEL_ROOM'     => ['Room' => Room::class],
        'DEL_ROOMTYPE' => ['RoomType' => RoomType::class],
        'DEL_FLATTYPE' => ['FlatType' => FlatType::class],
        'DEL_SOCRBASE' => ['AddressObjectType' => AddressObjectType::class],
        'DEL_STEAD'    => ['Stead' => Stead::class],
        'DEL_STRSTAT'  => ['StructureStatus' => StructureStatus::class],
    ];

    protected function configure()
    {
        $this
            ->setName('shiptor:fias:update')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('update-version', 'uv', InputOption::VALUE_OPTIONAL, 'Version of update'),
                    new InputOption('complete', 'c', InputOption::VALUE_OPTIONAL, 'Complete version of update'),
                ])
            )
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
        $complete = $input->getOption('complete');
        $version = $input->getOption('update-version');
        /** @var UpdateList[] $updateList */
        $updateList = $this->getEm()
            ->getRepository('ShiptorFiasBundle:UpdateList')
            ->getUpdateList($version)
            ->getQuery()
            ->getResult();

        foreach ($updateList as $item) {
            $dirName = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::FIAS_UPDATE_DIR.$item->getVersionId();
            $fileName = self::FIAS_UPDATE_FILE.$item->getVersionId().self::FILE_EXTENTION;
            $url = $item->getFiasDeltaXmlUrl();

            if ($complete) {
                $url = $item->getFiasCompleteXmlUrl();
            }

            if ($this->getFiasService()->downloadArchive($dirName, $fileName, $url)) {
                $this->getFiasService()->extractArchive($dirName, $fileName, $dirName);
            } else {
                continue;
            }

            if ($this->getFiasService()->xmlDbHandler($dirName, $this->transformersClasses, FiasService::FILL_DB) &&
                $this->getFiasService()->xmlDbHandler($dirName, $this->deleteDataClasses, FiasService::CLEAR_DB)
            ) {
                $item->setUpdatedAt(new \DateTime());
                $this->getEm()->merge($item);
                $this->getEm()->flush();
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
