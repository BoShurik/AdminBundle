<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 18:57
 */

namespace BoShurik\AdminBundle\Admin;

interface SidebarInterface
{
    /**
     * @return string
     */
    public function getSidebarName();

    /**
     * @return string
     */
    public function getSidebarIndexLink();

    /**
     * @return string
     */
    public function getSidebarNewLink();
}