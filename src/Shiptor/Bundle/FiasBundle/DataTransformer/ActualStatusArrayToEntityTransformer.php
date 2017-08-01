<?php
namespace Shiptor\Bundle\FiasBundle\DataTransformer;

use Shiptor\Bundle\FiasBundle\Entity\ActualStatus;
use Symfony\Component\Form\DataTransformerInterface;

class ActualStatusArrayToEntityTransformer implements DataTransformerInterface
{
    /**
     * @param array $value
     *
     * @return ActualStatus
     */
    public function transform($value)
    {
        $entity = new ActualStatus();

        $entity
            ->setActStatId($value['ACTSTATID'])
            ->setName($value['NAME'])
        ;

        return $entity;
    }

    /**
     * @param ActualStatus $value
     *
     * @return array
     */
    public function reverseTransform($value)
    {
        return [
            'ACTSTATID' => $value->getActStatId(),
            'NAME'      => $value->getName(),
        ];
    }
}