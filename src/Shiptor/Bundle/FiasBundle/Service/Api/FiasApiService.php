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
            ->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressObject(AddressObject::STATUS_ACTUAL, $type, null, $offset, $limit)
            ->getQuery()
            ->getResult()
        ;

        $result = [];
        $addressObjectTransformer = $this->container->get('shiptor_fias.service.address_object');
        $addressObjectTypeTransformer = $this->container->get('shiptor_fias.service.address_object_type');
        foreach ($data as $key => $item) {
            if ($item instanceof AddressObject) {
                $result[$key]['addressObjects'] = $addressObjectTransformer->transform($item);
            }

            if ($item instanceof AddressObjectType) {
                $result[$key-1]['addressObjectTypes'] = $addressObjectTypeTransformer->transform($item);
            }
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
}
