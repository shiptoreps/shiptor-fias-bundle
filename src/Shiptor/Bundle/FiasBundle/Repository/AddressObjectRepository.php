<?php

namespace Shiptor\Bundle\FiasBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;

/**
 * AddressObjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressObjectRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int|null $actual
     * @param int      $offset
     * @param int|null $limit
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getGroupedAddresses($actual = null, $offset = 0, $limit = null)
    {
        $query = $this
            ->createQueryBuilder('ao')
            ->select('ao.postalCode')
            ->where('ao.postalCode IS NOT NULL')
            ->groupBy('ao.postalCode')
            ->orderBy('ao.postalCode', 'ASC');

        if (null !== $actual) {
            $query
                ->andWhere('ao.actStatus = :actual')
                ->setParameter('actual', $actual);
        }

        if (null !== $limit) {
            if ($limit > 100000) {
                $limit = 100000;
            }

            $query
                ->setFirstResult($offset)
                ->setMaxResults($limit);
        }

        return $query;
    }

    /**
     * @param \DateTime|null $date
     * @param boolean|null   $actual
     * @param integer|null   $offset
     * @param integer|null   $limit
     * @param integer|null   $type
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAddressObject($actual = null, $type = null, \DateTime $date = null, $offset = 0, $limit = null)
    {
        $query = $this
            ->createQueryBuilder('ao')
            ->select('ao, objectType')
            ->leftJoin('ao.aoLevel', 'objectType')
            ->where('ao.shortName = objectType.scName')
            ->andWhere('LENGTH(ao.plainCode) <= 11')
            ->orderBy('ao.aoLevel', 'ASC')
            ->addOrderBy('ao.aoId', 'DESC');

        if (null !== $date) {
            $query
                ->andWhere('ao.updateDate >= :date')
                ->setParameter('date', $date);
        }

        if (null !== $actual) {
            $query
                ->andWhere('ao.actStatus = :actual')
                ->setParameter('actual', $actual);
        }

        if (null !== $type) {
            $query
                ->andWhere('ao.divType = :type')
                ->setParameter('type', $type);
        }

        if (null !== $limit) {
//            if ($limit > 100000) {
//                $limit = 100000;
//            }

            $query
                ->setFirstResult($offset)
                ->setMaxResults($limit);
        }

        return $query;
    }

    /**
     * @param \DateTime|null $date
     * @param boolean|null   $actual
     * @param integer|null   $type
     * @return Query
     */
    public function getPageQuery($actual = null, $type = null, \DateTime $date = null)
    {
        $query = $this
            ->createQueryBuilder('ao')
            ->orderBy('ao.updateDate', 'DESC')
            ->addOrderBy('ao.aoId', 'DESC');

        if (null !== $date) {
            $query
                ->andWhere('ao.updateDate >= :date')
                ->setParameter('date', $date);
        }

        if (null !== $actual) {
            $query
                ->andWhere('ao.actStatus = :actual')
                ->setParameter('actual', $actual);
        }

        if (null !== $type) {
            $query
                ->andWhere('ao.divType = :type')
                ->setParameter('type', $type);
        }

        return $query->getQuery();
    }

    public function getNextId($id)
    {
        return $this
            ->createQueryBuilder('ao')
            ->andWhere('ao.aoId = :id')
            ->setParameter('id', $id);
    }
}
