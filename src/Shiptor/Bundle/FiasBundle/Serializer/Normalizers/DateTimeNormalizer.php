<?php
namespace Shiptor\Bundle\FiasBundle\Serializer\Normalizers;

/**
 * Class DateTimeNormalizer
 */
class DateTimeNormalizer
{
    protected $entity;

    /**
     * @param $entity
     * @return mixed
     */
    public static function normalize($entity)
    {
        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\AddressObject) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\House) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\HouseInterval) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\Landmark) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\NormativeDocument) {
            if ($entity->getDocDate()) {
                $entity->setDocDate(new \DateTime($entity->getDocDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\Room) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }

        if ($entity instanceof \Shiptor\Bundle\FiasBundle\Entity\Stead) {
            if ($entity->getUpdateDate()) {
                $entity->setUpdateDate(new \DateTime($entity->getUpdateDate()));
            }
            if ($entity->getStartDate()) {
                $entity->setStartDate(new \DateTime($entity->getStartDate()));
            }
            if ($entity->getEndDate()) {
                $entity->setEndDate(new \DateTime($entity->getEndDate()));
            }
        }
    }
}