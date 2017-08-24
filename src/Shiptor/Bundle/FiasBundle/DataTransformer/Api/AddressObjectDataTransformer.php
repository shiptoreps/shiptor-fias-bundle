<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer\Api;

use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class AddressObjectDataTransformer
 */
class AddressObjectDataTransformer implements DataTransformerInterface
{
    /**
     * @param AddressObject $addressObject
     * @return array|null
     */
    public function transform($addressObject)
    {
        $result = null;

        if ($addressObject instanceof AddressObject) {
            $result = [
                'aoId' => $addressObject->getAoId(),
                'aoGuid' => $addressObject->getAoGuid(),
                'parentGuid' => $addressObject->getParentGuid(),
                'prevId' => $addressObject->getPrevId(),
                'nextId' => $addressObject->getNextId(),
                'formalName' => $addressObject->getFormalName(),
                'offName' => $addressObject->getOffName(),
                'shortName' => $addressObject->getShortName(),
                'aoLevel' => $this->setAoLevel($addressObject->getAoLevel()),
                'regionCode' => $addressObject->getRegionCode(),
                'areaCode' => $addressObject->getAreaCode(),
                'autoCode' => $addressObject->getAutoCode(),
                'cityCode' => $addressObject->getCityCode(),
                'ctArCode' => $addressObject->getCtArCode(),
                'placeCode' => $addressObject->getPlaceCode(),
                'streetCode' => $addressObject->getStreetCode(),
                'extrCode' => $addressObject->getExtrCode(),
                'sExtCode' => $addressObject->getSExtCode(),
                'plainCode' => $addressObject->getPlainCode(),
                'code' => $addressObject->getCode(),
                'currStatus' => $addressObject->getCurrStatus(),
                'actStatus' => $addressObject->getActStatus(),
                'liveStatus' => $addressObject->getLiveStatus(),
                'centStatus' => $addressObject->getCentStatus(),
                'operStatus' => $addressObject->getOperStatus(),
                'ifnsFl' => $addressObject->getIfnsFl(),
                'ifnsUl' => $addressObject->getIfnsUl(),
                'terrIfnsFl' => $addressObject->getTerrIfnsFl(),
                'terrIfnsUl' => $addressObject->getTerrIfnsUl(),
                'okato' => $addressObject->getOkato(),
                'oktmo' => $addressObject->getOktmo(),
                'postalCode' => $addressObject->getPostalCode(),
                'startDate' => $addressObject->getStartDate()->format('Y-m-d'),
                'endDate' => $addressObject->getEndDate()->format('Y-m-d'),
                'normDoc' => $addressObject->getNormDoc(),
                'cadNum' => $addressObject->getCadNum(),
                'divType' => $addressObject->getDivType(),
                'updateDate' => $addressObject->getUpdateDate()->format('Y-m-d'),
            ];
        }

        return $result;
    }

    /**
     * @param array $addressObject
     * @return mixed|void
     */
    public function reverseTransform($addressObject)
    {
        throw new \LogicException('Method not implemented.');
    }

    public function setAoLevel(AddressObjectType $addressObjectType) {
        return [
            'level' => $addressObjectType->getLevel(),
            'socrName' => $addressObjectType->getSocrName(),
            'scName' => $addressObjectType->getScName(),
            'kodTsT' => $addressObjectType->getKodTsT(),
        ];
    }
}
