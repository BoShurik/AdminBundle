<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 19:03
 */

namespace BoShurik\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ControllerCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $pool = $container->getDefinition('bo_shurik_admin.controller_pool');

        foreach ($container->findTaggedServiceIds('bo_shurik_admin.controller') as $id => $tags) {
            foreach ($tags as $tag) {
                $pool->addMethodCall('addController', array(
                    new Reference($id),
                    isset($tag['group']) ? $tag['group'] : 'default'
                ));
            }
        }
    }
}