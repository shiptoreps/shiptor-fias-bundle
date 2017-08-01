<?php
namespace Shiptor\Bundle\FiasBundle\DataTransformer;

use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Symfony\Component\Form\DataTransformerInterface;

class AddressObjectArrayToEntityTransformer implements DataTransformerInterface
{
    /**
     * @param array $value
     *
     * @return AddressObject
     */
    public function transform($value)
    {
        $entity = new AddressObject();

        $entity
            ->setAoId($value['AOID'])
            ->setAoGuid($value['AOGUID'])
            ->setParentGuid(isset($value['PARENTGUID']) ? $value['PARENTGUID'] : null)
            ->setPrevId(isset($value['PREVID']) ? $value['PREVID'] : null)
            ->setNextId(isset($value['NEXTID']) ? $value['NEXTID'] : null)
            ->setFormalName($value['FORMALNAME'])
            ->setOffName(isset($value['OFFNAME']) ? $value['OFFNAME'] : null)
            ->setShortName($value['SHORTNAME'])
            ->setAoLevel($value['AOLEVEL'])
            ->setRegionCode($value['REGIONCODE'])
            ->setAreaCode($value['AREACODE'])
            ->setAutoCode($value['AUTOCODE'])
            ->setCityCode($value['CITYCODE'])
            ->setCtArCode($value['CTARCODE'])
            ->setPlaceCode($value['PLACECODE'])
            ->setStreetCode($value['STREETCODE'])
            ->setExtrCode($value['EXTRCODE'])
            ->setSExtCode($value['SEXTCODE'])
            ->setPlainCode(isset($value['PLAINCODE']) ? $value['PLAINCODE'] : null)
            ->setCode(isset($value['CODE']) ? $value['CODE'] : null)
            ->setCurrStatus($value['CURRSTATUS'])
            ->setActStatus($value['ACTSTATUS'])
            ->setLiveStatus($value['LIVESTATUS'])
            ->setCentStatus($value['CENTSTATUS'])
            ->setOperStatus($value['OPERSTATUS'])
            ->setIfnsFl(isset($value['IFNSFL']) ? $value['IFNSFL'] : null)
            ->setIfnsUl(isset($value['IFNSUL']) ? $value['IFNSUL'] : null)
            ->setTerrIfnsFl(isset($value['TERRIFNSFL']) ? $value['TERRIFNSFL'] : null)
            ->setTerrIfnsUl(isset($value['TERRIFNSUL']) ? $value['TERRIFNSUL'] : null)
            ->setOkato(isset($value['OKATO']) ? $value['OKATO'] : null)
            ->setOktmo(isset($value['OKTMO']) ? $value['OKTMO'] : null)
            ->setPostalCode(isset($value['POSTALCODE']) ? $value['POSTALCODE'] : null)
            ->setStartDate(\DateTime::createFromFormat('Y-m-d', $value['STARTDATE']))
            ->setEndDate(\DateTime::createFromFormat('Y-m-d', $value['ENDDATE']))
            ->setNormDoc(isset($value['NORMDOC']) ? $value['NORMDOC'] : null)
            ->setCadNum(isset($value['CADNUM']) ? $value['CADNUM'] : null)
            ->setDivType(isset($value['DIVTYPE']) ? $value['DIVTYPE'] : null)
            ->setUpdateDate(\DateTime::createFromFormat('Y-m-d', $value['UPDATEDATE']))
        ;

        return $entity;
    }

    /**
     * @param AddressObject $value
     *
     * @return array
     */
    public function reverseTransform($value)
    {
        return [
            'AOID'       => $value->getAoId(),
            'AOGUID'     => $value->getAoGuid(),
            'PARENTGUID' => $value->getParentGuid(),
            'PREVID'     => $value->getPrevId(),
            'NEXTID'     => $value->getNextId(),
            'FORMALNAME' => $value->getFormalName(),
            'OFFNAME'    => $value->getOffName(),
            'SHORTNAME'  => $value->getShortName(),
            'AOLEVEL'    => $value->getAoLevel(),
            'REGIONCODE' => $value->getRegionCode(),
            'AREACODE'   => $value->getAreaCode(),
            'AUTOCODE'   => $value->getAutoCode(),
            'CITYCODE'   => $value->getCityCode(),
            'CTARCODE'   => $value->getCtArCode(),
            'PLACECODE'  => $value->getPlaceCode(),
            'STREETCODE' => $value->getStreetCode(),
            'EXTRCODE'   => $value->getExtrCode(),
            'SEXTCODE'   => $value->getSExtCode(),
            'PLAINCODE'  => $value->getPlainCode(),
            'CODE'       => $value->getCode(),
            'CURRSTATUS' => $value->getCurrStatus(),
            'ACTSTATUS'  => $value->getActStatus(),
            'LIVESTATUS' => $value->getLiveStatus(),
            'CENTSTATUS' => $value->getCentStatus(),
            'OPERSTATUS' => $value->getOperStatus(),
            'IFNSFL'     => $value->getIfnsFl(),
            'IFNSUL'     => $value->getIfnsUl(),
            'TERRIFNSFL' => $value->getTerrIfnsFl(),
            'TERRIFNSUL' => $value->getTerrIfnsUl(),
            'OKATO'      => $value->getOkato(),
            'OKTMO'      => $value->getOktmo(),
            'POSTALCODE' => $value->getPostalCode(),
            'STARTDATE'  => $value->getStartDate()->format('Y-m-d'),
            'ENDDATE'    => $value->getEndDate()->format('Y-m-d'),
            'NORMDOC'    => $value->getNormDoc(),
            'CADNUM'     => $value->getCadNum(),
            'DIVTYPE'    => $value->getDivType(),
            'UPDATEDATE' => $value->getUpdateDate()->format('Y-m-d'),
        ];
    }
}