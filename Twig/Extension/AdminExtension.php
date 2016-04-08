<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 19:34
 */

namespace BoShurik\AdminBundle\Twig\Extension;

use BoShurik\AdminBundle\Admin\ControllerPool;

class AdminExtension extends \Twig_Extension
{
    /**
     * @var ControllerPool
     */
    private $controllerPool;

    public function __construct(ControllerPool $controllerPool)
    {
        $this->controllerPool = $controllerPool;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('admin_sidebar_controllers', array($this->controllerPool, 'getSidebarControllers')),
            new \Twig_SimpleFunction('admin_widget_controllers', array($this->controllerPool, 'getWidgetControllers'))
        );
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'bo_shurik_admin_admin';
    }
}