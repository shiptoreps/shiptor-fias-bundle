<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer;

use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;

/**
 * Class AddressObjectTypeUpsertTransformer
 * @package Shiptor\Bundle\FiasBundle\DataTransformer
 */
class AddressObjectTypeUpsertTransformer implements DataTransformerInterface
{
    /**
     * @param AddressObjectType $value
     * @return array|null
     */
    public function transform($value)
    {
        if ($value instanceof AddressObjectType) {
            return [
                'kod_t_st' => $value->getKodTsT(),
                'sc_name' => $value->getScName(),
                'socr_name' => $value->getSocrName(),
                'level' => $value->getLevel(),
            ];
        }

        return null;
    }

    /**
     * @param array $value
     * @return AddressObjectType
     */
    public function reverseTransform($value)
    {
        $entity = new AddressObjectType();

        return $entity
            ->setKodTsT($value['kod_t_st'])
            ->setScName($value['sc_name'])
            ->setSocrName($value['socr_name'])
            ->setLevel($value['level']);
    }
}
