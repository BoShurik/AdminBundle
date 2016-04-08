<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:49
 */

namespace BoShurik\AdminBundle\Filter\Factory;

use BoShurik\AdminBundle\Filter\Filter\ORMFilter;
use BoShurik\AdminBundle\Filter\Mapping\ORMFilterMapping;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ORMFilterFactory implements FilterFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createFilter(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        return new ORMFilter(new ORMFilterMapping($objectManager, $objectRepository->getClassName()), $objectRepository);
    }

    /**
     * @inheritDoc
     */
    public function isApplicable(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        return $objectManager instanceof EntityManagerInterface &&
            $objectRepository instanceof EntityRepository
        ;
    }

}