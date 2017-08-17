<?php

namespace Shiptor\Bundle\FiasBundle\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\NullAdapter;
use Pagerfanta\Exception\NotIntegerMaxPerPageException;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Shiptor\Bundle\FiasBundle\Exception\InvalidPagerDataException;

/**
 * Class PagerService
 */
class PagerService
{
    const MESSAGE_ITEMS_NOT_FOUND = "Items for page %s were not found.";
    const MESSAGE_PER_PAGE_LIMIT_REACHED = "Items per page limit %s was reached.";
    const MESSAGE_PER_PAGE_INVALID_TYPE = "Parameter per page must be an integer.";
    const MESSAGE_ADDRESS_NOT_FOUND = "Address with id %s was not found.";

    const OPT_PER_PAGE_LIMIT = 'perPageLimit';
    const OPT_PAGE = 'page';
    const OPT_PER_PAGE = 'perPage';

    protected static $defaultsOptions = [
        self::OPT_PER_PAGE_LIMIT => 10,
        self::OPT_PAGE => 1,
        self::OPT_PER_PAGE => 10,
    ];

    /**
     * @param QueryBuilder|Query $query
     * @param array              $options
     * @return Pagerfanta
     * @throws InvalidPagerDataException
     */
    public function getPagerByQueryBuilder($query, $options = [])
    {
        return $this->getPager(new DoctrineORMAdapter($query, true, true), $options);
    }

    /**
     * @param array $items
     * @param array $options
     * @return Pagerfanta
     * @throws InvalidPagerDataException
     */
    public function getPagerByArray(array $items, $options = [])
    {
        return $this->getPager(new ArrayAdapter($items), $options);
    }

    /**
     * @param int   $count
     * @param array $options
     * @return Pagerfanta
     * @throws InvalidPagerDataException
     */
    public function getPagerByCount($count, $options = [])
    {
        return $this->getPager(new NullAdapter($count), $options);
    }

    /**
     * @param AdapterInterface $adapter
     * @param array            $options
     * @return Pagerfanta
     * @throws InvalidPagerDataException
     */
    protected function getPager(AdapterInterface $adapter, $options)
    {
        $options = array_merge(self::$defaultsOptions, $options);
        if ($options[self::OPT_PER_PAGE] > $options[self::OPT_PER_PAGE_LIMIT]) {
            throw new InvalidPagerDataException(sprintf(self::MESSAGE_PER_PAGE_LIMIT_REACHED, $options[self::OPT_PER_PAGE_LIMIT]));
        }
        $pager = new Pagerfanta($adapter);
        try {
            $pager->setMaxPerPage($options[self::OPT_PER_PAGE]);
            $pager->setCurrentPage($options[self::OPT_PAGE]);
        } catch (NotIntegerMaxPerPageException $e) {
            throw new InvalidPagerDataException(self::MESSAGE_PER_PAGE_INVALID_TYPE);
        } catch (NotValidCurrentPageException $e) {
            throw new InvalidPagerDataException(sprintf(self::MESSAGE_ITEMS_NOT_FOUND, $options[self::OPT_PAGE]));
        }

        return $pager;
    }
}
