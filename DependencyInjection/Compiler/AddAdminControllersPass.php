<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 22:20
 */

namespace BoShurik\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AddAdminControllersPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $controllerService = $container->getDefinition('boshurik_admin.controller_service');

        $adminControllers = array();

        foreach ($container->findTaggedServiceIds('boshurik.admin') as $id => $attributes) {
            $adminControllers[] = $id;
        }

        $controllerService->addMethodCall('setControllers', array($adminControllers));
    }
}
