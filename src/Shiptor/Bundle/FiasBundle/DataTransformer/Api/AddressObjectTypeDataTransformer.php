<?php

namespace Shiptor\Bundle\FiasBundle\DataTransformer\Api;

use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class AddressObjectTypeDataTransformer
 */
class AddressObjectTypeDataTransformer implements DataTransformerInterface
{
    /**
     * @param AddressObject $addressObject
     * @return array|null
     */
    public function transform($addressObject)
    {
        $result = null;

        if ($addressObject instanceof AddressObjectType) {
            $result = [
                'level' => $addressObject->getLevel(),
                'scName' => $addressObject->getScName(),
                'socrName' => $addressObject->getSocrName(),
                'kodTsT' => $addressObject->getKodTsT(),
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
}
