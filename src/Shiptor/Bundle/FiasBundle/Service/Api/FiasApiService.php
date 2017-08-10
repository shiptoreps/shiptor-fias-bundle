<?php
namespace Shiptor\Bundle\FiasBundle\Service\Api;

use Moriony\RpcServer\Exception\InvalidParamException;
use Moriony\RpcServer\Request\RpcRequestInterface;
use Moriony\RpcServer\Response\JsonRpcResponse;
use Shiptor\Bundle\FiasBundle\AbstractService;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Exception\BasicException;
use Shiptor\Bundle\FiasBundle\Repository\AddressObjectRepository;
use Shiptor\Bundle\FiasBundle\Service\PagerService;

/**
 * Class FiasApi
 */
class FiasApiService extends AbstractService
{
    /**
     * @param RpcRequestInterface $request
     * @return array | string
     * @throws InvalidParamException
     * @throws \Exception
     */
    public function getActualAddresses(RpcRequestInterface $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $type = $request->get('type');

        if (!is_numeric($type) || !in_array($type, AddressObject::DIV_TYPE_RANGE)) {
            $type = null;
        }

        $query = $this
            ->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getPageQuery(AddressObject::STATUS_ACTUAL, $type);

        try {
            /** @var AddressObject[] $pager */
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
        foreach ($pager as $settlement) {
            $result['addressObjects'][] = $transformer->transform($settlement);
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
        $page = $request->get('page');
        $limit = $request->get('limit');
        $date = $request->get('date');

        $query = $this->getDoctrine()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getPageQuery(null, null, $date);

        try {
            /** @var AddressObject[] $pager */
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
        foreach ($pager as $settlement) {
            $result['addressObjects'][] = $transformer->transform($settlement);
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
