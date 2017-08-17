<?php
namespace Shiptor\Bundle\FiasBundle\Command;

use Shiptor\Bundle\FiasBundle\AbstractCommand;
use Shiptor\Bundle\FiasBundle\Entity\UpdateList;
use Shiptor\Bundle\FiasBundle\Serializer\Converters\AttributeConverter;
use Shiptor\Bundle\FiasBundle\Service\FiasService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use XMLReader;

/**
 * Class UpdateListCommand
 * @package Shiptor\Bundle\FiasBundle\Command
 */
class UpdateListCommand extends AbstractCommand
{
    const FIAS_UPDATE_URL = 'http://fias.nalog.ru/WebServices/Public/DownloadService.asmx';
    const FIAS_GET_ALL_DOWNLOAD_FILE_INFO = 'GetAllDownloadFileInfo';
    const FIAS_GET_LAST_DOWNLOAD_FILE_INFO = 'GetLastDownloadFileInfo';
    const FIAS_UPDATE_DIR = 'fias_update_list';
    const FIAS_UPDATE_FILE = 'fias_updat_list.xml';

    const XML_TAG_DOWNLOAD_FILE_INFO = 'DownloadFileInfo';

    /** @var  \SoapClient */
    private $client;

    protected function configure()
    {
        $this
            ->setName('shiptor:fias:update:list')
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
        $response = $this->fiasGetUpdatesApiCall();

        if (empty($response)) {
            throw new InvalidParameterException('Missing expected response.');
        }

        $dir = sys_get_temp_dir().DIRECTORY_SEPARATOR.self::FIAS_UPDATE_DIR;
        $this->saveAsXML($response, $dir, self::FIAS_UPDATE_FILE);

        $reader = new XMLReader();
        $reader->open($dir.DIRECTORY_SEPARATOR.self::FIAS_UPDATE_FILE);

        while ($reader->read()) {
            if ($reader->name === self::XML_TAG_DOWNLOAD_FILE_INFO && $reader->nodeType === XMLReader::ELEMENT) {
                $converter = new AttributeConverter(new UpdateList());
                $objectNormalizer = new ObjectNormalizer(null, $converter);
                $serializer = new Serializer([$objectNormalizer], [new XmlEncoder()]);

                /** @var UpdateList $entity */
                $entity = $serializer->deserialize($reader->readOuterXml(), UpdateList::class, 'xml');

                $existsEntity = $this->getEm()->getRepository('ShiptorFiasBundle:UpdateList')->find($entity->getVersionId());

                if ($existsEntity) {
                    continue;
                }

                $this->getEm()->persist($entity);

                unset($entity);
            }
        }

        $this->getEm()->flush();
        $this->getEm()->clear();

        $output->writeln('Fias Update List has been completed success.');

        return 0;
    }

    /**
     * @return string
     */
    protected function fiasGetUpdatesApiCall()
    {
        $arguments =
            '<?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
              <soap12:Body>
                <GetAllDownloadFileInfo xmlns="http://fias.nalog.ru/WebServices/Public/DownloadService.asmx" />
              </soap12:Body>
            </soap12:Envelope>';

        $this->getSoapClient(self::FIAS_UPDATE_URL.'?wsdl', ['trace' => TRUE]);

        $this->client->__soapCall(self::FIAS_GET_ALL_DOWNLOAD_FILE_INFO, array($arguments));

        return $this->client->__getLastResponse();
    }

    /**
     * @param string $data
     * @param string $dir
     * @param string $fileName
     */
    protected function saveAsXML($data, $dir, $fileName)
    {
        $this->getFiasService()->makeDir($dir);

        $file = fopen($dir.DIRECTORY_SEPARATOR.$fileName, 'w+');
        fwrite($file, $data);
        fclose($file);

        if (!file_exists($dir.DIRECTORY_SEPARATOR.$fileName)) {
            throw new InvalidParameterException($dir.DIRECTORY_SEPARATOR.$fileName.' file could not be created.');
        }
    }

    /**
     * @param string $host
     * @return \SoapClient
     */
    public function getSoapClient($host, $options = null)
    {
        $this->client = new \SoapClient($host, $options);

        return $this->client;
    }

    /**
     * @return FiasService
     */
    protected function getFiasService()
    {
        return $this->getContainer()->get('shiptor_fias.service.fias');
    }
}
