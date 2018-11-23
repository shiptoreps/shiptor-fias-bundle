<?php
namespace Shiptor\Bundle\FiasBundle\Service\Api;

use Moriony\RpcServer\Exception\InvalidParamException;
use Moriony\RpcServer\Request\RpcRequestInterface;
use Shiptor\Bundle\FiasBundle\AbstractService;
use Shiptor\Bundle\FiasBundle\Entity\AddressObject;
use Shiptor\Bundle\FiasBundle\Exception\ObjectDeletedException;

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
            $result['addressObjects'][] = $this->findParentAndRegionAndLoclLevel($addressObject);
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

        $result = $this->findParentAndRegionAndLoclLevel($addressObject);

        if (isset($result['status']) && $result['status'] === 'error') {
            return $result;
        }

        if ($result['actStatus'] !== 1) {
            return [
                'status' => 'error',
                'error'  => "Returned data do not have actual status 1.",
                'data'   => $result,
            ];
        }

        if ($result['currStatus'] !== 0) {
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
        $addressObjectType = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObjectType')->getAddressType($address);
        $transformer = $this->getAddressObjectTransformer();
        $transformer->setShortName($addressObjectType);

        return $transformer->transform($address);
    }

    /**
     * @param RpcRequestInterface $request
     * @return null|array
     */
    public function getParentByCode(RpcRequestInterface $request)
    {
        $plainCode = $request->get('code');

        $addressObjectRepo = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject');
        $addressObjectTypeRepo = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObjectType');


        /** @var AddressObject $addressObject */
        $addressObject = $addressObjectRepo
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
        $parentAddressObject = $addressObjectRepo
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

        $transformer = $this->getAddressObjectTransformer();
        $transformer->setShortName($addressObjectTypeRepo->getAddressType($last));

        return $transformer->transform($last);
    }

    /**
     * @param AddressObject $addressObject
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function findParentAndRegionAndLoclLevel(AddressObject $addressObject)
    {
        $addressObjectRepo = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject');
        $addressObjectTypeRepo = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObjectType');

        try {
            /** @var AddressObject $lastAddressObject */
            $lastAddressObject = $addressObjectRepo->getLast($addressObject);
        } catch (ObjectDeletedException $exception) {
            return [
                'status' => 'error',
                'message' => "Cannot found actual object by requested code ({$addressObject->getPlainCode()})",
            ];
        }

        /** @var AddressObject $parentAddressObject */
        $parentAddressObject = $addressObjectRepo
            ->createQueryBuilder('ao')
            ->where('ao.aoGuid = :parent')
            ->setParameter('parent', $lastAddressObject->getParentGuid())
            ->setMaxResults(1)
            ->orderBy('ao.plainCode')
            ->getQuery()
            ->getOneOrNullResult();

        $addressType = $addressObjectTypeRepo->getAddressType($lastAddressObject);

        if (!$parentAddressObject) {
            return  [
                'offName' => $lastAddressObject->getOffName(),
                'scName' => $addressType->getScName(),
                'socrName' => $addressType->getSocrName(),
                'plainCode' => $lastAddressObject->getPlainCode(),
                'currStatus' => $lastAddressObject->getCurrStatus(),
                'actStatus' => $lastAddressObject->getActStatus(),
                'liveStatus' => $lastAddressObject->getLiveStatus(),
                'aoLevel' => $lastAddressObject->getAoLevel(),
                'parent' => null,
                'region' => null,
                'localLevel' => 1,
                'parentLocalLevel' => null,
            ];
        }

        try {
            list($localLevel, $region) = $addressObjectRepo->getRegionAndLocalLevel($lastAddressObject);
            $regionType = $addressObjectTypeRepo->getAddressType($region);
        } catch (ObjectDeletedException $exception) {
            return [
                'status' => 'error',
                'message' => "Region was not found. Need to check region of requested object by code ({$lastAddressObject->getPlainCode()})",
            ];
        }

        try {
            $lastParentAddressObject = $addressObjectRepo->getLast($parentAddressObject);
            $parentType = $addressObjectTypeRepo->getAddressType($lastParentAddressObject);
            list($parentLocalLevel) = $addressObjectRepo->getRegionAndLocalLevel($lastParentAddressObject);
        } catch (ObjectDeletedException $exception) {
            return [
                'status' => 'error',
                'message' => "Parent was not found. Need to check parent of requested object by code ({$lastAddressObject->getPlainCode()})",
            ];
        }

        $parentTransformer = $this->getAddressObjectTransformer()->setShortName($parentType);
        $regionTransformer = $this->getAddressObjectTransformer()->setShortName($regionType);

        return [
            'offName' => $lastAddressObject->getOffName(),
            'scName' => $addressType->getScName(),
            'socrName' => $addressType->getSocrName(),
            'plainCode' => $lastAddressObject->getPlainCode(),
            'currStatus' => $lastAddressObject->getCurrStatus(),
            'actStatus' => $lastAddressObject->getActStatus(),
            'liveStatus' => $lastAddressObject->getLiveStatus(),
            'aoLevel' => $lastAddressObject->getAoLevel(),
            'parent' => $parentTransformer->transform($lastParentAddressObject),
            'region' => $regionTransformer->transform($region),
            'localLevel' => $localLevel,
            'parentLocalLevel' => $parentLocalLevel,
        ];
    }

    /**
     * @return array|null
     */
    public function getLastUpdateDate()
    {
        $lastVersion = $this->getEm()->getRepository('ShiptorFiasBundle:UpdateList')->findLast();

        if (!$lastVersion) {
            return null;
        }

        $textDate = $lastVersion->getTextVersion();

        if (preg_match('/\d{2}.\d{2}.\d{4}/', $lastVersion->getTextVersion(), $matches)) {
            $textDate = $matches[0];
        }

        return [
            'version' => $lastVersion->getVersionId(),
            'date' => $textDate,
        ];
    }

    /**
     * @param RpcRequestInterface $request
     * @return array
     * @throws ObjectDeletedException|\Exception
     */
    public function getPreviousCodes(RpcRequestInterface $request)
    {
        $code = $request->get('plainCode');

        $codes = [];
        /** @var AddressObject $addressObject */
        $addressObject = $this->getEm()->getRepository('ShiptorFiasBundle:AddressObject')
            ->createQueryBuilder('ao')
            ->where('ao.plainCode = :plainCode')
            ->orWhere('ao.code = :plainCode')
            ->setParameter('plainCode', $code)
            ->setMaxResults(1)
            ->orderBy('ao.updateDate', 'ASC')
            ->getQuery()->getOneOrNullResult();

        if (!$addressObject) {
            return [];
        }

        $codes[] = $addressObject->getPlainCode();
        $prevAddress = $addressObject->getPrevId();
        while ($prevAddress) {
            try {
                $codes[] = $prevAddress->getPlainCode();
                $prevAddress = $prevAddress->getPrevId();

                if ($prevAddress->getRemovedAt()) {
                    throw new ObjectDeletedException();
                }
            } catch (\Exception $exception) {
                if (preg_match('/IDs aoId(.+) was not found/i', $exception->getMessage())) {
                    throw new ObjectDeletedException();
                }

                throw $exception;
            }

        }

        return array_unique($codes);
    }
}
