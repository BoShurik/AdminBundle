<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 17:59
 */

namespace BoShurik\AdminBundle\Generator;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class AdminGenerator extends Generator
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * @var string $skeletonDir
     */
    protected $skeletonDir;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param string $skeletonDir
     */
    public function __construct(Filesystem $filesystem, $skeletonDir)
    {
        $this->filesystem  = $filesystem;
        $this->skeletonDir = $skeletonDir;
    }

    public function generate(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata, $routePrefix)
    {
        echo 'TODO: generate';

        if (count($metadata->identifier) > 1) {
            throw new \RuntimeException('The CRUD generator does not support entity classes with multiple primary keys.');
        }

        if (!in_array('id', $metadata->identifier)) {
            throw new \RuntimeException('The CRUD generator expects the entity object has a primary key field named "id" with a getId() method.');
        }

//        $this->routePrefix = $routePrefix;
//        $this->routeNamePrefix = str_replace('/', '_', $routePrefix);
//        $this->entity   = $entity;
//        $this->bundle   = $bundle;
//        $this->metadata = $metadata;

        $this->generateForm($bundle, $entity, $metadata);
        $this->generateController();
        $this->generateView();
        $this->generateRoute();

        echo 'Done';
    }

    public function generateForm(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata)
    {
        echo 'TODO: generateForm';

        $classPath = $bundle->getPath() .'/Form/Admin';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $className = $entityClass .'Type';

        $target = sprintf('%s/%s.php', $classPath, $className);

        $this->renderFile($this->skeletonDir, 'form/FormType.php', $target, array(
            'dir'              => $this->skeletonDir,
            'fields'           => $this->getFieldsFromMetadata($metadata),
            'namespace'        => $bundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
            'form_class'       => $className,
            'form_type_name'   => strtolower(str_replace('\\', '_', $bundle->getNamespace()).($parts ? '_' : '').implode('_', $parts) .'_'. $className),
        ));
    }

    public function generateController()
    {
        echo 'TODO: generateController';
    }

    public function generateView()
    {
        echo 'TODO: generateView';
    }

    public function generateRoute()
    {
        echo 'TODO: generateRoute';
    }

    /**
     * Returns an array of fields. Fields can be both column fields and
     * association fields.
     *
     * @param ClassMetadataInfo $metadata
     * @return array $fields
     */
    private function getFieldsFromMetadata(ClassMetadataInfo $metadata)
    {
        $fields = (array) $metadata->fieldNames;

        // Remove the primary key field if it's not managed manually
        if (!$metadata->isIdentifierNatural()) {
            $fields = array_diff($fields, $metadata->identifier);
        }

        foreach ($metadata->associationMappings as $fieldName => $relation) {
            if ($relation['type'] !== ClassMetadataInfo::ONE_TO_MANY) {
                $fields[] = $fieldName;
            }
        }

        return $fields;
    }
}
