<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 19:58
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Controller extends BaseController implements AdminControllerInterface
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}