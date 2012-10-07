<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 20:00
 */

namespace BoShurik\AdminBundle\Controller;

interface AdminControllerInterface
{
    /**
     * Returns route for create link
     *
     * @return string
     */
    public function getNewLink();

    /**
     * Returns route for list link
     *
     * @return string
     */
    public function getListLink();

    /**
     * Returns routes for other actions links
     *
     * @return array
     */
    public function getActionsLinks();

}
