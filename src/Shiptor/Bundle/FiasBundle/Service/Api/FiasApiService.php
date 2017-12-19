<?php
namespace Shiptor\Bundle\FiasBundle\Service\Api;

use Moriony\RpcServer\Exception\InvalidParamException;
use Moriony\RpcServer\Request\RpcRequestInterface;
use Pagerfanta\Pagerfanta;
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
            ->getResult();
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
            ->getResult();

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
            'count'          => $pager->count(),
            'page'           => $pager->getCurrentPage(),
            'per_page'       => $pager->getMaxPerPage(),
            'pages'          => $pager->getNbPages(),
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
            ->getRepository('ShiptorFiasBundle:AddressObject');

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

            $nextID = $result->getNextId();
        } while ($result);

        return [
            'plainCode' => ($result) ? $result->getPlainCode() : null,
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
                ->getActualAddress($item)
                ->getQuery()
                ->getResult();

            $addressObject = $addressObjects[0];

            if (null === $addressObject->getParentGuid()) {
                $parent[] = null;

                continue;
            }

            $parents = $this
                ->getEm()
                ->getRepository('ShiptorFiasBundle:AddressObject')
                ->getParentAddress(AddressObject::STATUS_ACTUAL, $addressObject->getParentGuid())
                ->getQuery()
                ->getResult();

            if (!isset($parents[0])) {
                $parentGuid = $addressObject->getParentGuid();

                do {
                    $parents = $this
                        ->getEm()
                        ->getRepository('ShiptorFiasBundle:AddressObject')
                        ->getParentAddress(null, $parentGuid)
                        ->getQuery()
                        ->getResult();

                    if ($parents[0]->getActStatus() === AddressObject::STATUS_ACTUAL) {
                        break;
                    }

                    $parentGuid = $parents[0]->getParentGuid();
                } while ($parents[0]);
            }

            $parent[] = $parents[0];
        }

        $result = [];
        $transformer = $this->container->get('shiptor_fias.service.address_object');
        foreach ($parent as $addressObject) {
            $result['addressObjects'][] = $transformer->transform($addressObject);
        }

        return $result;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     */
    public function getActualParent(RpcRequestInterface $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 1);

        $data = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressParents($offset, $limit)
            ->getQuery()
            ->getResult();

        $result = [];
        $addressObjectTransformer = $this->container->get('shiptor_fias.service.address_object');
        foreach ($data as $key => $item) {
            $result['addressObjects'][] = $addressObjectTransformer->transform($item);
        }

        return $result;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     */
    public function getDataByPostalCode(RpcRequestInterface $request)
    {
        $postalCode = $request->get('postalCode');

        $data = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressByPostalCode($postalCode)
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($data as $key => $item) {
            /** @var AddressObject $item */
            $result['data'][$key]['regionCode'] = $item->getRegionCode();
            $result['data'][$key]['offName'] = $item->getOffName();
            $result['data'][$key]['scName'] = $item->getShortName()->getScName();
            $result['data'][$key]['socrName'] = $item->getShortName()->getSocrName();
            $result['data'][$key]['plainCode'] = $item->getPlainCode();
            $result['data'][$key]['currStatus'] = $item->getCurrStatus();
            $result['data'][$key]['centStatus'] = $item->getCentStatus();
        }

        return $result;
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     */
    public function getActualPlainCode(RpcRequestInterface $request)
    {
        $plainCode = $request->get('plainCode');
        /** @var AddressObject $addressObject */
        $addressObject = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressByPlainCode($plainCode)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$addressObject) {
            return [
                'status' => 'error',
                'error'  => "This {$plainCode} plainCode doesn't exist!",
            ];
        }

        $nextId = $addressObject->getNextId();
        $last = $addressObject;
        while ($nextId) {
            /** @var AddressObject $last */
            $last = $nextId;
            $nextId = $nextId->getNextId();
        }

        $result = [];
        $result['offName'] = $last->getOffName();
        $result['scName'] = $last->getShortName()->getScName();
        $result['socrName'] = $last->getShortName()->getSocrName();
        $result['plainCode'] = $last->getPlainCode();
        $result['currStatus'] = $last->getCurrStatus();
        $result['actStatus'] = $last->getActStatus();
        $result['liveStatus'] = $last->getLiveStatus();
        $result['aoLevel'] = $last->getAoLevel();

        $data = $this->findNextParentCodeAndLoclLevel($last);
        if ($data) {
            $result['localLevel'] = $data['localLevel'];
            $result['parentCode'] = $data['parentCode'];
        }

        if ($last->getActStatus() !== 1) {
            return [
                'status' => 'error',
                'error'  => "Returned data do not have actual status 1.",
                'data'   => $result,
            ];
        }

        if ($last->getCurrStatus() !== 0) {
            return [
                'status' => 'error',
                'error'  => "Returned data do not have current status 0.",
                'data'   => $result,
            ];
        }

        return [
            'status' => 'ok',
            'data'   => $result,
        ];
    }

    /**
     * @param RpcRequestInterface $request
     * @return array|null
     * @throws InvalidParamException
     */
    public function getAddressByFias(RpcRequestInterface $request)
    {
        $address = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')->findOneBy([
            'aoGuid' => $request->get(0),
            'actStatus' => 1,
        ]);

        if (!$address) {
            throw new InvalidParamException('Address not found');
        }

        return $this->container->get('shiptor_fias.service.address_object')->transform($address);
    }

    /**
     * @param RpcRequestInterface $request
     * @return null|array
     */
    public function getParentByCode(RpcRequestInterface $request)
    {
        $plainCode = $request->get('code');

        /** @var AddressObject $addressObject */
        $addressObject = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressByPlainCode($plainCode)
            ->andWhere('ao.actStatus = :actStatus')
            ->andWhere('ao.nextId IS NULL')
            ->setParameter('actStatus', AddressObject::STATUS_ACTUAL)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$addressObject || null === $addressObject->getParentGuid()) {
            return null;
        }

        /** @var AddressObject $parentAddressObject */
        $parentAddressObject = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getDirectParent($addressObject)
            ->getQuery()
            ->getOneOrNullResult();

        $nextId = $parentAddressObject->getNextId();
        $last = $parentAddressObject;
        while ($nextId) {
            /** @var AddressObject $last */
            $last = $nextId;
            $nextId = $nextId->getNextId();
        }

        return $this->container->get('shiptor_fias.service.address_object')->transform($last);
    }

    protected function findNextParentCodeAndLoclLevel(AddressObject $addressObject)
    {
        /** @var AddressObject $parentAddressObject */
        $parentAddressObject = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->createQueryBuilder('ao')
            ->where('ao.aoGuid = :parent')
            ->setParameter('parent', $addressObject->getParentGuid())
            ->setMaxResults(1)
            ->orderBy('ao.plainCode')
            ->getQuery()
            ->getOneOrNullResult();

        if (!$parentAddressObject) {
            return null;
        }

        $nextAddress = $parentAddressObject->getNextId();
        $lastAddress = $parentAddressObject;
        $localLevel = 1;
        while ($nextAddress) {
            /** @var AddressObject $lastAddress */
            $lastAddress = $nextAddress;
            $nextAddress = $nextAddress->getNextId();
            $localLevel++;
        }

        return [
            'localLevel' => $localLevel,
            'parentCode' => $lastAddress->getPlainCode(),
        ];
    }
}
