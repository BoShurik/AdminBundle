<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 06.10.12
 * Time: 23:27
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('BoShurikAdminBundle:Default:index.html.twig');
    }
}