<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:50
 */

namespace BoShurik\AdminBundle\Filter\Factory;

use BoShurik\AdminBundle\Filter\Filter\MongoDBFilter;
use BoShurik\AdminBundle\Filter\Mapping\MongoDBFilterMapping;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

class MongoDBFilterFactory implements FilterFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createFilter(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        return new MongoDBFilter(new MongoDBFilterMapping($objectManager, $objectRepository->getClassName()), $objectRepository);
    }

    /**
     * @inheritDoc
     */
    public function isApplicable(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        return $objectManager instanceof DocumentManager &&
            $objectRepository instanceof DocumentRepository
        ;
    }

}