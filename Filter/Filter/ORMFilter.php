<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:39
 */

namespace BoShurik\AdminBundle\Filter\Filter;

use BoShurik\AdminBundle\Filter\FilterException;
use BoShurik\AdminBundle\Filter\Mapping\FilterMappingInterface;
use BoShurik\AdminBundle\Filter\Mapping\Mapping;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ORMFilter implements FilterInterface
{
    /**
     * @var FilterMappingInterface
     */
    private $mapping;

    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(FilterMappingInterface $mapping, EntityRepository $repository)
    {
        $this->mapping = $mapping;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function filter(array $data = null, array $order = null)
    {
        $builder = $this->repository->createQueryBuilder('o');
        $this->initOrder($builder, $order);

        $data = array_filter($data, function($value) {
            return !is_null($value);
        });
        
        /**
         * @var string $field
         * @var Mapping $mapping
         */
        foreach ($data as $field => $value) {
            if (!isset($this->mapping[$field])) {
                throw new FilterException(sprintf('Can\'t find mapping for filed %s', $field));
            }

            $mapping = $this->mapping[$field];

            switch ($mapping->getType()) {
                case Mapping::STRING:
                case Mapping::TEXT:
                    $builder
                        ->andWhere(sprintf('o.%1$s LIKE :%1$s', $mapping->getField()))
                        ->setParameter($mapping->getField(), sprintf('%%%s%%', $value))
                    ;
                    break;
                case Mapping::INTEGER:
                case Mapping::FLOAT:
                case Mapping::BOOLEAN:
                    $builder
                        ->andWhere(sprintf('o.%1$s = :%1$s', $mapping->getField()))
                        ->setParameter($mapping->getField(), $value)
                    ;
                    break;
                case Mapping::DATE:
                case Mapping::DATETIME:
                case Mapping::TIME:
                    $builder
                        ->andWhere(sprintf('o.%1$s = :%1$s', $mapping->getField()))
                        ->setParameter($mapping->getField(), $value)
                    ;
                    break;
                case Mapping::DATE_FROM:
                case Mapping::DATETIME_FROM:
                case Mapping::TIME_FROM:
                    $builder
                        ->andWhere(sprintf('o.%1$s >= :%1$s', $mapping->getField()))
                        ->setParameter($mapping->getField(), $value)
                    ;
                    break;
                case Mapping::DATE_TO:
                case Mapping::DATETIME_TO:
                case Mapping::TIME_TO:
                    $builder
                        ->andWhere(sprintf('o.%1$s <= :%1$s', $mapping->getField()))
                        ->setParameter($mapping->getField(), $value)
                    ;
                    break;
                case Mapping::OBJECT:
                    $getter = sprintf('get%s', ucfirst($mapping->getJoinId()));
                    $builder
                        ->innerJoin(sprintf('o.%s', $mapping->getField()), $mapping->getField())
                        ->andWhere(sprintf('%s.%s = :%1$s_id', $mapping->getField(), $mapping->getJoinId()))
                        ->setParameter(sprintf('%s_id', $mapping->getField()), $value->$getter())
                    ;
                    break;
                default:
                    throw new FilterException(sprintf('Can\'t filter by filed %s with type %s', $mapping->getField(), $mapping->getType()));
            }
        }

        return $builder;
    }

    /**
     * @param QueryBuilder $builder
     * @param array|null $order
     */
    private function initOrder(QueryBuilder $builder, array $order = null)
    {
        if (!$order) {
            return;
        }

        foreach ($order as $field => $direction) {
            $builder->addOrderBy(sprintf('o.%s', $field), $direction);
        }
    }
}