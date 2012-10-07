<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 01.10.12
 * Time: 23:25
 */

namespace BoShurik\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use BoShurik\AdminBundle\DependencyInjection\Compiler\AddAdminControllersPass;

class BoShurikAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddAdminControllersPass());
    }
}
