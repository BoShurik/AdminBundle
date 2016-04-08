<?php
/**
 * User: boshurik
 * Date: 11.02.16
 * Time: 15:07
 */

namespace BoShurik\AdminBundle\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('BoShurikAdminBundle:Dashboard:index.html.twig');
    }
}