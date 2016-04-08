<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 18:56
 */

namespace BoShurik\AdminBundle\Admin;

class ControllerPool
{
    /**
     * @var array
     */
    private $controllers;

    public function __construct()
    {
        $this->controllers = array();
    }

    /**
     * @param object $controller
     * @param string $group
     */
    public function addController($controller, $group)
    {
        $this->controllers[$group][] = $controller;
    }

    /**
     * @return array
     */
    public function getSidebarControllers()
    {
        return $this->filterByInstance(SidebarInterface::class);
    }

    /**
     * @return array
     */
    public function getWidgetControllers()
    {
        return $this->filterByInstance(WidgetInterface::class);
    }

    /**
     * @param string $class
     * @return array
     */
    private function filterByInstance($class)
    {
        $result = array();
        foreach ($this->controllers as $group => $controllers) {
            foreach ($controllers as $controller) {
                if ($controller instanceof $class) {
                    $result[$group][] = $controller;
                }
            }
        }

        return $result;
    }
}