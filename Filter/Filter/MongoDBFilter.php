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
use Doctrine\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\DocumentRepository;

class MongoDBFilter implements FilterInterface
{
    /**
     * @var FilterMappingInterface
     */
    private $mapping;

    /**
     * @var DocumentRepository
     */
    private $repository;

    public function __construct(FilterMappingInterface $mapping, DocumentRepository $repository)
    {
        $this->mapping = $mapping;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function filter(array $data = null, array $order = null)
    {
        $builder = $this->repository->createQueryBuilder();
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
                        ->field($mapping->getField())
                        ->equals(array('$regex' => $value, '$options' => '-i'))
                    ;
                    break;
                case Mapping::BOOLEAN:
                case Mapping::INTEGER:
                case Mapping::FLOAT:
                    $builder
                        ->field($mapping->getField())
                        ->equals((float)$value)
                    ;
                    break;
                case Mapping::INTEGER_FROM:
                case Mapping::FLOAT_FROM:
                    $builder
                        ->field($mapping->getField())
                        ->gte((float)$value)
                    ;
                    break;
                case Mapping::INTEGER_TO:
                case Mapping::FLOAT_TO:
                    $builder
                        ->field($mapping->getField())
                        ->lte((float)$value)
                    ;
                    break;
                case Mapping::DATE:
                case Mapping::DATETIME:
                case Mapping::TIME:
                    $builder
                        ->field($mapping->getField())
                        ->equals($value);
                    ;
                    break;
                case Mapping::DATE_FROM:
                case Mapping::DATETIME_FROM:
                case Mapping::TIME_FROM:
                    $builder
                        ->field($mapping->getField())
                        ->gte($value);
                    ;
                    break;
                case Mapping::DATE_TO:
                case Mapping::DATETIME_TO:
                case Mapping::TIME_TO:
                    $builder
                        ->field($mapping->getField())
                        ->lte($value);
                    ;
                    break;
                default:
                    throw new FilterException(sprintf('Can\'t filter by filed %s with type %s', $mapping->getField(), $mapping->getType()));
            }
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array|null $order
     */
    private function initOrder(Builder $builder, array $order = null)
    {
        if (!$order) {
            return;
        }

        foreach ($order as $field => $direction) {
            $builder->sort(sprintf('%s', $field), $direction);
        }
    }
}