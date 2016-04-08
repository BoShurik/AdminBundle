<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:43
 */

namespace BoShurik\AdminBundle\Filter\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use BoShurik\AdminBundle\Filter\FilterException;

class FilterFactoryPool
{
    /**
     * @var FilterFactoryInterface[]
     */
    private $factories;

    public function __construct()
    {
        $this->factories = array();
    }

    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $objectRepository
     * @return \BoShurik\AdminBundle\Filter\Filter\FilterInterface
     */
    public function createFilter(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        return $this->getFactory($objectManager, $objectRepository)->createFilter($objectManager, $objectRepository);
    }

    /**
     * @param FilterFactoryInterface $factory
     */
    public function addFactory(FilterFactoryInterface $factory)
    {
        $this->factories[] = $factory;
    }

    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $objectRepository
     * @return FilterFactoryInterface
     */
    private function getFactory(ObjectManager $objectManager, ObjectRepository $objectRepository)
    {
        foreach ($this->factories as $factory) {
            if ($factory->isApplicable($objectManager, $objectRepository)) {
                return $factory;
            }
        }

        throw new FilterException('Can\'t filter given object manager and repository');
    }
}