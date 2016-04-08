<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:41
 */

namespace BoShurik\AdminBundle\Filter\Mapping;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Types\Type;

use BoShurik\AdminBundle\Filter\FilterException;

class MongoDBFilterMapping extends AbstractFilterMapping
{
    public function __construct(DocumentManager $documentManager, $class)
    {
        $metadata = $documentManager->getClassMetadata($class);

        foreach ($metadata->fieldMappings as $name => $mapping) {
            switch ($mapping['type']) {
                case Type::ID:
                case Type::INT:
                case Type::INTEGER:
                    $this->mapping[$name] = new Mapping($name, Mapping::INTEGER);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::INTEGER_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::INTEGER_TO);
                    break;
                case Type::FLOAT:
                    $this->mapping[$name] = new Mapping($name, Mapping::FLOAT);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::FLOAT_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::FLOAT_TO);
                    break;
                case Type::BOOLEAN:
                    $this->mapping[$name] = new Mapping($name, Mapping::BOOLEAN);
                    break;
                case Type::STRING:
                    $this->mapping[$name] = new Mapping($name, Mapping::STRING);
                    break;
                case Type::DATE:
                    $this->mapping[$name] = new Mapping($name, Mapping::DATE);
                    $this->mapping[$name . self::SUFFIX_FROM] = new Mapping($name, Mapping::DATE_FROM);
                    $this->mapping[$name . self::SUFFIX_TO] = new Mapping($name, Mapping::DATE_TO);
                    break;
                default:
                    throw new FilterException(sprintf('Can\'t process %s mapping type for simple field', $mapping['type']));
            }
        }
    }
}