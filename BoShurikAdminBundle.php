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

use BoShurik\AdminBundle\DependencyInjection\Compiler\FilterFactoryCompilerPass;
use BoShurik\AdminBundle\DependencyInjection\Compiler\GeneratorCompilerPass;
use BoShurik\AdminBundle\DependencyInjection\Compiler\ControllerCompilerPass;

class BoShurikAdminBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FilterFactoryCompilerPass());
        $container->addCompilerPass(new GeneratorCompilerPass());
        $container->addCompilerPass(new ControllerCompilerPass());
    }
}
