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
        if (count($metadata->identifier) > 1) {
            throw new \RuntimeException('The CRUD generator does not support entity classes with multiple primary keys.');
        }

        if (!in_array('id', $metadata->identifier)) {
            throw new \RuntimeException('The CRUD generator expects the entity object has a primary key field named "id" with a getId() method.');
        }

        $this->generateForm($bundle, $entity, $metadata);
        $this->generateController($bundle, $entity, $routePrefix);
        $this->generateView($bundle, $entity, $metadata, $routePrefix);
        $this->generateRoute($bundle, $entity, $routePrefix);
        $this->generateService($bundle, $entity);
    }

    public function generateForm(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata)
    {
        $classPath = $bundle->getPath() .'/Form/Admin';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $className = $entityClass .'Type';

        $target = sprintf('%s%s/%s.php', $classPath, implode('/', $parts),  $className);

        $this->renderFile($this->skeletonDir, 'form/FormType.php', $target, array(
            'fields'           => $this->getFieldsFromMetadata($metadata),
            'namespace'        => $bundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
            'form_class'       => $className,
            'form_type_name'   => strtolower(str_replace('\\', '_', $bundle->getNamespace()).($parts ? '_' : '').implode('_', $parts) .'_'. $className),
        ));
    }

    public function generateController(BundleInterface $bundle, $entity, $routePrefix)
    {
        $classPath = $bundle->getPath() .'/Controller/Admin';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $className = $entityClass .'Controller';

        $target = sprintf('%s%s/%s.php', $classPath, implode('/', $parts), $className);

        $this->renderFile($this->skeletonDir, 'controller/Controller.php', $target, array(
            'bundle'           => $bundle->getName(),
            'namespace'        => $bundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
            'route_name_prefix' => 'admin_'. str_replace('/', '_', $routePrefix)
        ));
    }

    public function generateView(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata, $routePrefix)
    {
        $classPath = $bundle->getPath() .'/Resources/views/Admin';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $views = array('index', 'show', 'new', 'edit');

        $fields = $metadata->fieldMappings;

        foreach ($views as $view) {
            $target = sprintf('%s%s/%s/%s.html.twig', $classPath, implode('/', $parts), $entityClass, $view);

            $this->renderFile($this->skeletonDir, 'views/'. $view .'.html.twig', $target, array(
                'fields'           => $fields,
                'entity_class'     => $entityClass,
                'route_name_prefix' => 'admin_'. str_replace('/', '_', $routePrefix)
            ));
        }
    }

    public function generateRoute(BundleInterface $bundle, $entity, $routePrefix)
    {
        $classPath = $bundle->getPath() .'/Resources/config/routing/admin';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $bundleParts = explode('\\', $bundle->getNamespace());

        $target = sprintf('%s%s/%s.yml', $classPath, implode('/', $parts), strtolower($entityClass));

        $this->renderFile($this->skeletonDir, 'config/routing.yml', $target, array(
            'vendor'           => strtolower(array_shift($bundleParts)),
            'bundle_name'      => str_replace('bundle', '', strtolower(array_pop($bundleParts))),
            'entity_class'     => $entityClass,
            'route_prefix'     => $routePrefix,
            'route_name_prefix' => 'admin_'. str_replace('/', '_', $routePrefix)
        ));

        $classPath = $bundle->getPath() .'/Resources/config';

        $target = sprintf('%s/routing_admin.yml', $classPath);

        $this->renderFile($this->skeletonDir, 'config/routing_admin.yml', $target, array(
            'bundle'           => $bundle->getName(),
            'entity_class'     => $entityClass,
            'route_prefix'     => $routePrefix,
            'route_name_prefix' => 'admin_'. str_replace('/', '_', $routePrefix)
        ), true);
    }

    public function generateService(BundleInterface $bundle, $entity)
    {
        $classPath = $bundle->getPath() .'/Resources/config';

        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $bundleParts = explode('\\', $bundle->getNamespace());

        $target = sprintf('%s/admin.yml', $classPath);

        $this->renderFile($this->skeletonDir, 'config/service.yml', $target, array(
            'vendor'           => strtolower(array_shift($bundleParts)),
            'bundle_name'      => str_replace('bundle', '', strtolower(array_pop($bundleParts))),
            'namespace'        => $bundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
        ), true);
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
