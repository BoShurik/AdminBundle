<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:41
 */

namespace BoShurik\AdminBundle\Filter\Mapping;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

use BoShurik\AdminBundle\Filter\FilterException;

class ORMFilterMapping extends AbstractFilterMapping
{
    public function __construct(EntityManagerInterface $entityManager, $class)
    {
        $metadata = $entityManager->getClassMetadata($class);

        foreach ($metadata->fieldMappings as $name => $mapping) {
            switch ($mapping['type']) {
                case Type::BOOLEAN:
                    $this->mapping[$name] = new Mapping($name, Mapping::BOOLEAN);
                    break;
                case Type::STRING:
                    $this->mapping[$name] = new Mapping($name, Mapping::STRING);
                    break;
                case Type::TEXT:
                    $this->mapping[$name] = new Mapping($name, Mapping::TEXT);
                    break;
                case Type::INTEGER:
                case Type::BIGINT:
                case Type::SMALLINT:
                    $this->mapping[$name] = new Mapping($name, Mapping::INTEGER);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::INTEGER_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::INTEGER_TO);
                    break;
                case Type::DECIMAL:
                    $this->mapping[$name] = new Mapping($name, Mapping::FLOAT);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::FLOAT);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::FLOAT);
                    break;
                case Type::DATE:
                    $this->mapping[$name] = new Mapping($name, Mapping::DATE);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::DATE_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::DATE_TO);
                    break;
                case Type::DATETIME:
                    $this->mapping[$name] = new Mapping($name, Mapping::DATETIME);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::DATETIME_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::DATETIME_TO);
                    break;
                case Type::TIME:
                    $this->mapping[$name] = new Mapping($name, Mapping::TIME);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::TIME_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::TIME_TO);
                    break;
                case Type::TARRAY:
                case Type::JSON_ARRAY:
                case Type::SIMPLE_ARRAY:
                    // Ignore
                    break;
                default:
                    throw new FilterException(sprintf('Can\'t process %s mapping type for simple field', $mapping['type']));
            }
        }

        foreach ($metadata->getAssociationMappings() as $name => $mapping) {
            switch ($mapping['type']) {
                case ClassMetadataInfo::MANY_TO_MANY:
                case ClassMetadataInfo::ONE_TO_MANY:
                case ClassMetadataInfo::MANY_TO_ONE:
                case ClassMetadataInfo::ONE_TO_ONE:
                    $associationMapping = $entityManager->getClassMetadata($mapping['targetEntity']);
                    $associationIdentifier = $associationMapping->getIdentifier();

                    $this->mapping[$name] = new Mapping($name, Mapping::OBJECT, $associationIdentifier[0]);
                    break;
                default:
                    throw new FilterException(sprintf('Can\'t process %s mapping type for association field', $mapping['type']));
            }
        }
    }
}