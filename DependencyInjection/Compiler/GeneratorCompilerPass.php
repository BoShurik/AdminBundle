<?php
/**
 * User: boshurik
 * Date: 15.04.16
 * Time: 19:09
 */

namespace BoShurik\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GeneratorCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->compileGenerators($container);
        $this->compileQuestions($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function compileGenerators(ContainerBuilder $container)
    {
        $pool = $container->getDefinition('bo_shurik_admin.generator.core.generator_pool');

        foreach ($container->findTaggedServiceIds('bo_shurik_admin.generator.generator') as $id => $tags) {
            foreach ($tags as $tag) {
                $pool->addMethodCall('addGenerator', array(
                    new Reference($id),
                ));
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function compileQuestions(ContainerBuilder $container)
    {
        $pool = $container->getDefinition('bo_shurik_admin.generator.core.interrogator_pool');

        foreach ($container->findTaggedServiceIds('bo_shurik_admin.generator.interrogator') as $id => $tags) {
            foreach ($tags as $tag) {
                $pool->addMethodCall('addInterrogator', array(
                    new Reference($id),
                ));
            }
        }
    }
}