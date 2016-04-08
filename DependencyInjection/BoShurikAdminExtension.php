<?php
/**
 * User: boshurik
 * Date: 01.10.12
 * Time: 23:30
 */

namespace BoShurik\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BoShurikAdminExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('administrator.yml');
        $loader->load('filter.yml');
        $loader->load('router.yml');
        $loader->load('admin.yml');

        $loader->load('generator/core.yml');
        $loader->load('generator/interrogator.yml');
        $loader->load('generator/generator.yml');

        $container->setParameter('bo_shurik_admin.pagination.name', $config['pagination']['name']);

        $container->setParameter('bo_shurik_admin.administrator.class',       $config['administrator']['class']);
        $container->setParameter('bo_shurik_admin.administrator.form_type',   $config['administrator']['form_type']);
        $container->setParameter('bo_shurik_admin.administrator.filter_type', $config['administrator']['filter_type']);

        $this->initSkeletonDirs($container);
    }

    private function initSkeletonDirs(ContainerBuilder $container)
    {
        $skeletonDirs = array();

        $skeletonDirs[] = __DIR__ . '/../Resources/skeleton';
        $skeletonDirs[] = __DIR__ . '/../Resources';

        $container->setParameter('bo_shurik_admin.generator.skeleton_dirs', $skeletonDirs);
    }
}
