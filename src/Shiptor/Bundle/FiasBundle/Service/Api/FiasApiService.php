<?php
namespace Shiptor\Bundle\FiasBundle\Service\Api;

use Moriony\RpcServer\Exception\InvalidParamException;
use Moriony\RpcServer\Request\RpcRequestInterface;
use Moriony\RpcServer\Response\JsonRpcResponse;
use Pagerfanta\Pagerfanta;
use Shiptor\Bundle\FiasBundle\AbstractService;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Entity\AddressObjectType;
use Shiptor\Bundle\FiasBundle\Exception\BasicException;
use Shiptor\Bundle\FiasBundle\Repository\AddressObjectRepository;
use Shiptor\Bundle\FiasBundle\Service\PagerService;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class FiasApi
 */
class FiasApiService extends AbstractService
{
    /**
     * @param RpcRequestInterface $request
     * @return array
     * @throws InvalidParamException
     * @throws \Exception
     */
    public function getGroupedActualAddresses(RpcRequestInterface $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 1);

        return $this
            ->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getGroupedAddresses(AddressObject::STATUS_ACTUAL, $offset, $limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     * @throws InvalidParamException
     * @throws \Exception
     */
    public function getActualAddresses(RpcRequestInterface $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 1);
        $type = $request->get('type');

        if (!is_numeric($type) || !in_array($type, AddressObject::DIV_TYPE_RANGE)) {
            $type = null;
        }

        $data = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressObject(AddressObject::STATUS_ACTUAL, $type, null, $offset, $limit)
            ->getQuery()
            ->getResult()
        ;

        $result = [];
        $addressObjectTransformer = $this->container->get('shiptor_fias.service.address_object');
        foreach ($data as $key => $item) {
            $result['addressObjects'][] = $addressObjectTransformer->transform($item);
        }

        return $result;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array | string
     * @throws InvalidParamException
     * @throws \Exception
     */
    public function getAddressesSinceDate(RpcRequestInterface $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 1);
        $date = new \DateTime($request->get('date'));

        $query = $this->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getPageQuery(null, null, $date);

        try {
            /** @var Pagerfanta $pager */
            $pager = $this->getPagerService()->getPagerByQueryBuilder($query, [
                PagerService::OPT_PAGE           => $page,
                PagerService::OPT_PER_PAGE       => $limit,
                PagerService::OPT_PER_PAGE_LIMIT => $limit,
            ]);
        } catch (BasicException $exception) {
            return [
                'error' => $exception->getMessage(),
            ];
        }

        $result = [
            'count' => $pager->count(),
            'page' => $pager->getCurrentPage(),
            'per_page' => $pager->getMaxPerPage(),
            'pages' => $pager->getNbPages(),
            'addressObjects' => [],
        ];

        $transformer = $this->container->get('shiptor_fias.service.address_object');
        foreach ($pager as $addressObject) {
            $result['addressObjects'][] = $transformer->transform($addressObject);
        }

        return $result;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     */
    public function getAddressByUUID(RpcRequestInterface $request)
    {
        $aoId = $request->get('aoId');

        /** @var AddressObjectRepository $repo */
        $repo = $this
            ->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
        ;

        $nextID = $aoId;

        do {
            /** @var AddressObject $result */
            $result = $repo
                ->getNextId($nextID)
                ->getQuery()
                ->getOneOrNullResult();

            if (null === $result->getNextId()) {
                break;
            }

            $nextID = $result->getNextId()->serialize();
        } while($result);

        return [
            'plainCode' => ($result)?$result->getPlainCode():null,
        ];
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     */
    public function getParent(RpcRequestInterface $request)
    {
        $data = $request->get('data');
        $parent = [];

        foreach ($data as $item) {
            /** @var AddressObject[] $addressObjects */
            $addressObjects = $this
                ->getEm()
                ->getRepository('ShiptorFiasBundle:AddressObject')
                ->createQueryBuilder('ao')
                ->where('ao.offName = :offName')
                ->andWhere('ao.aoLevel = :aoLevel')
                ->andWhere('ao.shortName = :shortName')
                ->andWhere('ao.plainCode = :plainCode')
                ->andWhere('ao.actStatus = :actStatus')
                ->setParameter('offName', $item['offName'])
                ->setParameter('aoLevel', $item['aoLevel'])
                ->setParameter('shortName', $item['shortName'])
                ->setParameter('plainCode', $item['plainCode'])
                ->setParameter('actStatus', AddressObject::STATUS_ACTUAL)
                ->getQuery()
                ->getResult();

            $addressObject = $addressObjects[0];

            if (null === $addressObject->getParentGuid()) {
                // в место $addressObject нужно поставить null
                $parent[] = $addressObject;
            }

            $parents = $this
                ->getEm()
                ->getRepository('ShiptorFiasBundle:AddressObject')
                ->createQueryBuilder('ao')
                ->where('ao.aoGuid = :aoGuid')
                ->andWhere('ao.actStatus = :actStatus')
                ->setParameter('aoGuid', $addressObject->getParentGuid())
                ->setParameter('actStatus', AddressObject::STATUS_ACTUAL)
                ->getQuery()
                ->getResult();

            $parent[] = $parents[0];
        }

        $result = [];
        $transformer = $this->container->get('shiptor_fias.service.address_object');
        foreach ($parent as $addressObject) {
            $result['addressObjects'][] = $transformer->transform($addressObject);
        }

        return $result;
    }
}
