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
    public function getActualAddresses(RpcRequestInterface $request)
    {
        $params = [
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit', 1),
            'operationStatus' => $request->get('operationStatus'),
            'updateDate' => $request->get('updateDate'),
            'actualStatus' => AddressObject::STATUS_ACTUAL,
            'currentStatus' => AddressObject::STATUS_CURRNET,
        ];

        /** @var AddressObject[] $addressObjects */
        $addressObjects = $this
            ->getEm()
            ->getRepository('ShiptorFiasBundle:AddressObject')
            ->getAddressObject($params)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($addressObjects as $key => $addressObject) {
            $data = [
                'offName' => $addressObject->getOffName(),
                'scName' => $addressObject->getShortName()->getScName(),
                'socrName' => $addressObject->getShortName()->getSocrName(),
                'plainCode' => $addressObject->getPlainCode(),
                'currStatus' => $addressObject->getCurrStatus(),
                'actStatus' => $addressObject->getActStatus(),
                'liveStatus' => $addressObject->getLiveStatus(),
                'aoLevel' => $addressObject->getAoLevel(),
            ];

            $result['addressObjects'][] = array_merge_recursive($data, $this->findParentAndRegionAndLoclLevel($addressObject));
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
     * @throws \Doctrine\ORM\NonUniqueResultException
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

        $result = [
            'offName' => $addressObject->getOffName(),
            'scName' => $addressObject->getShortName()->getScName(),
            'socrName' => $addressObject->getShortName()->getSocrName(),
            'plainCode' => $addressObject->getPlainCode(),
            'currStatus' => $addressObject->getCurrStatus(),
            'actStatus' => $addressObject->getActStatus(),
            'liveStatus' => $addressObject->getLiveStatus(),
            'aoLevel' => $addressObject->getAoLevel(),
        ];

        $result = array_merge_recursive($result, $this->findParentAndRegionAndLoclLevel($addressObject));

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

    /**
     * @param AddressObject $addressObject
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findParentAndRegionAndLoclLevel(AddressObject $addressObject)
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
            return [];
        }
        /** @var AddressObject $lastAddressObject */
        $lastParentAddressObject = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')->getLast($parentAddressObject);
        $lastAddressObject = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')->getLast($addressObject);
        list($localLevel, $region) = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')->getRegionAndLocalLevel($lastAddressObject);
        list($parentLocalLevel, $parentRegion) = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')->getRegionAndLocalLevel($lastParentAddressObject);

        return [
            'parent' => $this->container->get('shiptor_fias.service.address_object')->transform($lastParentAddressObject),
            'region' => $this->container->get('shiptor_fias.service.address_object')->transform($region),
            'localLevel' => $localLevel,
            'parentLocalLevel' => $parentLocalLevel,
        ];
    }
}
