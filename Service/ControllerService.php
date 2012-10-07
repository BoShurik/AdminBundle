<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 20:41
 */

namespace BoShurik\AdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerService
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var array $containerServices
     */
    private $controllers;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->controllers = array();
    }

    /**
     * @param array $controllers
     */
    public function setControllers($controllers)
    {
        $this->controllers = $controllers;
    }

    /**
     * @return \BoShurik\AdminBundle\Controller\AdminControllerInterface[]
     */
    public function getControllerServices()
    {
        $services = array();

        foreach ($this->controllers as $controller) {
            $service = $this->container->get($controller);

            $services[] = $service;
        }

        return $services;
    }
}
