<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer\Api;

use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Class AddressObjectDataTransformer
 */
class AddressObjectDataTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $level;

    /**
     * @var string
     */
    private $socrName;

    /**
     * @var string
     */
    private $scName;

    /**
     * @var string
     */
    private $kodTsT;

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
                'shortName' => $this->getShortName(),
                'aoLevel' => $addressObject->getAoLevel(),
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

    /**
     * @param AddressObjectType $addressObjectType
     * @return $this
     */
    public function setShortName(AddressObjectType $addressObjectType) {
        $this->level = $addressObjectType->getLevel();
        $this->socrName = $addressObjectType->getSocrName();
        $this->scName = $addressObjectType->getScName();
        $this->kodTsT = $addressObjectType->getKodTsT();

        return $this;
    }

    /**
     * @return array
     */
    public function getShortName() {
        if (!$this->level || !$this->socrName || !$this->scName || !$this->kodTsT) {
            throw new MissingOptionsException('Transformer will contain all parameters', ['level', 'socrName', 'scName', 'kodTsT']);
        }

        return [
            'level' => $this->level,
            'socrName' => $this->socrName,
            'scName' => $this->scName,
            'kodTsT' => $this->kodTsT,
        ];
    }
}
