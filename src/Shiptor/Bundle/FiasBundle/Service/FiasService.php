<?php
namespace Shiptor\Bundle\FiasBundle\Service;

use Shiptor\Bundle\FiasBundle\AbstractService;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FiasService
 * @package ShiptorFiasBundle\Service
 */
class FiasService extends AbstractService
{
    const FIAS_FULL_DB_FILE = 'fias_dbf.rar';

    /**
     * @param string $destination
     */
    public function downloadFullArchive($destination)
    {
        $this->makeDir($destination);

        file_put_contents($destination.DIRECTORY_SEPARATOR.self::FIAS_FULL_DB_FILE, fopen("http://fias.nalog.ru/Public/Downloads/Actual/fias_xml.rar", 'r'));
    }

    /**
     * @param string $rarDir
     * @param string $extractPath
     */
    public function extractArchive($rarDir, $extractPath)
    {
        $this->makeDir($extractPath);

        $rar_file = rar_open($rarDir.DIRECTORY_SEPARATOR.self::FIAS_FULL_DB_FILE);
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
}
