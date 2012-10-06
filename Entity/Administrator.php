<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 0:04
 */

namespace BoShurik\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Administrator
 *
 * @ORM\Table(name="administrator")
 * @ORM\Entity()
 */
class Administrator implements AdvancedUserInterface
{
    const ROLE_DEFAULT = 'ROLE_ADMIN';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string $plainPassword
     */
    private $plainPassword;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var array $roles
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var boolean $expired
     *
     * @ORM\Column(name="expired", type="boolean")
     */
    private $expired;

    /**
     * @var boolean $locked
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;

    /**
     * @var \DateTime $lastLogin
     *
     * @ORM\Column(name="lastLogin", type="datetime")
     */
    private $lastLogin;

    /**
     * @var string $lastIp
     *
     * @ORM\Column(name="lastIp", type="string", length=32, nullable=true)
     */
    private $lastIp;

    public function __construct()
    {
        $this->enabled = true;
        $this->expired = false;
        $this->locked = false;

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        $this->roles = array();

        $this->lastLogin = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = self::ROLE_DEFAULT;

        return array_unique($roles);
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
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param string $lastIp
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;
    }

    /**
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return Boolean true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    function isAccountNonExpired()
    {
        return !$this->expired;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return Boolean true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    function isAccountNonLocked()
    {
        return !$this->locked;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return Boolean true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return Boolean true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}