<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:33
 */

namespace BoShurik\AdminBundle\Filter\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use BoShurik\AdminBundle\Filter\Filter\FilterInterface;

interface FilterFactoryInterface
{
    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $objectRepository
     * @return FilterInterface
     */
    public function createFilter(ObjectManager $objectManager, ObjectRepository $objectRepository);

    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $objectRepository
     * @return boolean
     */
    public function isApplicable(ObjectManager $objectManager, ObjectRepository $objectRepository);
}