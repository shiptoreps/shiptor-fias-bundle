<?php
namespace Shiptor\Bundle\FiasBundle\Command;

use Shiptor\Bundle\FiasBundle\AbstractCommand;
use Shiptor\Bundle\FiasBundle\Service\FiasService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class UpdateCommand extends AbstractCommand
{
    const FIAS_UPDATE_URL = 'http://fias.nalog.ru/WebServices/Public/DownloadService.asmx';
    const FIAS_GET_ALL_DOWNLOAD_FILE_INFO = 'GetAllDownloadFileInfo';
    const FIAS_GET_LAST_DOWNLOAD_FILE_INFO = 'GetLastDownloadFileInfo';
    const FIAS_UPDATE_DIR = 'fias_updates';
    const FIAS_UPDATE_FILE = 'fias_updates.xml';

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
        $arguments =
            '<?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
              <soap12:Body>
                <GetAllDownloadFileInfo xmlns="http://fias.nalog.ru/WebServices/Public/DownloadService.asmx" />
              </soap12:Body>
            </soap12:Envelope>'
        ;

        $headers = [
            'Host: fias.nalog.ru',
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: '.strlen($arguments),
            'SOAPAction: '.self::FIAS_UPDATE_URL.'/'.self::FIAS_GET_ALL_DOWNLOAD_FILE_INFO,
        ];

        $ch = curl_init(self::FIAS_UPDATE_URL);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $arguments,
        ]);

        $xml = curl_exec($ch);
        $httpCode = $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);;

        if ( $httpCode == 200 ) {
            $dir = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::FIAS_UPDATE_DIR;
            $this->getFiasService()->makeDir($dir);

            $file = fopen($dir.DIRECTORY_SEPARATOR.self::FIAS_UPDATE_FILE, 'w+');
            fwrite($file, $xml);
            fclose($file);
//            try {
//                $xmlElements = new \SimpleXMLElement($xml);
//
//                $xmlElements->asXML($dir.DIRECTORY_SEPARATOR.self::FIAS_UPDATE_FILE);
//            } catch (\Exception $exception) {
//                dump($exception->getMessage());exit;
//            }
        }

        curl_close($ch);
        fclose($xml);

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
