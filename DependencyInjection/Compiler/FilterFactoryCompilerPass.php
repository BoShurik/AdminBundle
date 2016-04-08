<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 13:18
 */

namespace BoShurik\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $pool = $container->getDefinition('bo_shurik_admin.filter.factory_pool');

        foreach ($container->findTaggedServiceIds('bo_shurik_admin.filter_factory') as $id => $tags) {
            foreach ($tags as $tag) {
                $pool->addMethodCall('addFactory', array(
                    new Reference($id),
                ));
            }
        }
    }
}