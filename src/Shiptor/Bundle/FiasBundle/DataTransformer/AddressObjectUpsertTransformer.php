<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer;

use Shiptor\Bundle\FiasBundle\Entity\AddressObject;

/**
 * Class AddressObjectUpsertTransformer
 * @package Shiptor\Bundle\FiasBundle\DataTransformer
 */
class AddressObjectUpsertTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return array|null
     */
    public function transform($value)
    {
        if ($value instanceof AddressObject) {
            return [
                'ao_id' => $value->getAoId(),
                'ao_guid' => $value->getAoGuid(),
                'parent_guid' => $value->getParentGuid(),
                'prev_id' => $value->getPrevId(),
                'next_id' => $value->getNextId(),
                'formal_name' => $value->getFormalName(),
                'off_name' => $value->getOffName(),
                'short_name' => $value->getShortName(),
                'ao_level' => $value->getAoLevel(),
                'region_code' => $value->getRegionCode(),
                'area_code' => $value->getAreaCode(),
                'auto_code' => $value->getAutoCode(),
                'city_code' => $value->getCityCode(),
                'ct_ar_code' => $value->getCtArCode(),
                'place_code' => $value->getPlaceCode(),
                'street_code' => $value->getStreetCode(),
                'extr_code' => $value->getExtrCode(),
                's_ext_code' => $value->getSExtCode(),
                'plain_code' => $value->getPlainCode(),
                'code' => $value->getCode(),
                'curr_status' => $value->getCurrStatus(),
                'act_status' => $value->getActStatus(),
                'live_status' => $value->getLiveStatus(),
                'cent_status' => $value->getCentStatus(),
                'oper_status' => $value->getOperStatus(),
                'ifns_fl' => $value->getIfnsFl(),
                'ifns_ul' => $value->getIfnsUl(),
                'terr_ifns_fl' => $value->getTerrIfnsFl(),
                'terr_ifns_ul' => $value->getTerrIfnsUl(),
                'okato' => $value->getOkato(),
                'oktmo' => $value->getOktmo(),
                'postal_code' => $value->getPostalCode(),
                'start_date' => $value->getStartDate()->format('Y-m-d'),
                'end_date' => $value->getEndDate()->format('Y-m-d'),
                'norm_doc' => $value->getNormDoc(),
                'cad_num' => $value->getCadNum(),
                'div_type' => $value->getDivType(),
                'update_date' => $value->getUpdateDate()->format('Y-m-d'),
            ];
        }

        return null;
    }

    /**
     * @param array $value
     * @return AddressObject
     */
    public function reverseTransform($value)
    {
        $entity = new AddressObject();

        $entity
            ->setAoId($value['ao_id'])
            ->setAoGuid($value['ao_guid'])
            ->setParentGuid(isset($value['parent_guid']) ? $value['parent_guid'] : null)
            ->setPrevId(isset($value['prev_id']) ? $value['prev_id'] : null)
            ->setNextId(isset($value['next_id']) ? $value['next_id'] : null)
            ->setFormalName($value['formal_name'])
            ->setOffName(isset($value['off_name']) ? $value['off_name'] : null)
            ->setShortName($value['short_name'])
            ->setAoLevel($value['ao_level'])
            ->setRegionCode($value['region_code'])
            ->setAreaCode($value['area_code'])
            ->setAutoCode($value['auto_code'])
            ->setCityCode($value['city_code'])
            ->setCtArCode($value['ct_ar_code'])
            ->setPlaceCode($value['place_code'])
            ->setStreetCode($value['street_code'])
            ->setExtrCode($value['extr_code'])
            ->setSExtCode($value['s_ext_code'])
            ->setPlainCode(isset($value['plain_code']) ? $value['plain_code'] : null)
            ->setCode(isset($value['code']) ? $value['code'] : null)
            ->setCurrStatus($value['curr_status'])
            ->setActStatus($value['act_status'])
            ->setLiveStatus($value['live_status'])
            ->setCentStatus($value['cent_status'])
            ->setOperStatus($value['oper_status'])
            ->setIfnsFl(isset($value['ifns_fl']) ? $value['ifns_fl'] : null)
            ->setIfnsUl(isset($value['ifns_ul']) ? $value['ifns_ul'] : null)
            ->setTerrIfnsFl(isset($value['terr_ifns_fl']) ? $value['terr_ifns_fl'] : null)
            ->setTerrIfnsUl(isset($value['terr_ifns_ul']) ? $value['terr_ifns_ul'] : null)
            ->setOkato(isset($value['okato']) ? $value['okato'] : null)
            ->setOktmo(isset($value['oktmo']) ? $value['oktmo'] : null)
            ->setPostalCode(isset($value['postal_code']) ? $value['postal_code'] : null)
            ->setStartDate(\DateTime::createFromFormat('Y-m-d', $value['start_date']))
            ->setEndDate(\DateTime::createFromFormat('Y-m-d', $value['end_date']))
            ->setNormDoc(isset($value['norm_doc']) ? $value['norm_doc'] : null)
            ->setCadNum(isset($value['cad_num']) ? $value['cad_num'] : null)
            ->setDivType(isset($value['div_type']) ? $value['div_type'] : null)
            ->setUpdateDate(\DateTime::createFromFormat('Y-m-d', $value['update_date']));

        return $entity;
    }
}
