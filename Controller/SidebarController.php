<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 22:27
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class SidebarController extends BaseController
{
    public function sidebarAction()
    {
        $controllerService = $this->getControllerService();

        return $this->render('BoShurikAdminBundle:Sidebar:sidebar.html.twig', array(
            'controllers' => $controllerService->getControllerServices()
        ));
    }

    /**
     * @return \BoShurik\AdminBundle\Service\ControllerService
     */
    private function getControllerService()
    {
        return $this->get('boshurik_admin.controller_service');
    }
}
