<?php
/**
 * User: boshurik
 * Date: 08.04.16
 * Time: 18:31
 */

namespace BoShurik\AdminBundle\Administrator;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends AdvancedUserInterface
{
    /**
     * @param string $password
     * @return mixed
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword);
}