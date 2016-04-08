<?php
/**
 * User: boshurik
 * Date: 01.10.12
 * Time: 23:39
 */

namespace BoShurik\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('boshurik_admin');

        $rootNode
            ->children()
                ->arrayNode('pagination')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultValue('p')->end()
                    ->end()
                ->end()
                ->arrayNode('administrator')->isRequired()
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                        ->scalarNode('form_type')->defaultValue('BoShurik\AdminBundle\Form\Type\Admin\Administrator\AdministratorType')->end()
                        ->scalarNode('filter_type')->defaultValue('BoShurik\AdminBundle\Form\Type\Admin\Administrator\AdministratorFilterType')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
