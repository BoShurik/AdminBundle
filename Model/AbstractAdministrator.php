<?php
/**
 * User: boshurik
 * Date: 08.04.16
 * Time: 18:25
 */

namespace BoShurik\AdminBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use BoShurik\AdminBundle\Administrator\UserInterface;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractAdministrator implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $locked;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     */
    protected $plainPassword;

    public function __construct()
    {
        $this->enabled = true;
        $this->locked = false;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array(
            self::ROLE_ADMIN
        );
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    /**
     * @inheritDoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
}