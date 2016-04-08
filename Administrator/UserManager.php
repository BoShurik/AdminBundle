<?php
/**
 * User: boshurik
 * Date: 08.04.16
 * Time: 18:31
 */

namespace BoShurik\AdminBundle\Administrator;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var string
     */
    private $class;

    public function __construct(ObjectManager $objectManager, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator, $class)
    {
        $this->objectManager = $objectManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->class = $class;
    }

    /**
     * @return UserInterface
     */
    public function createUser()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * @param UserInterface $user
     * @param null $plainPassword
     * @return string
     */
    public function setPassword(UserInterface $user, $plainPassword = null)
    {
        if (!$plainPassword) {
            $plainPassword = substr(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36), 0, 5);
        }
        $user->setPlainPassword($plainPassword);

        return $plainPassword;
    }

    /**
     * @param UserInterface $user
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $errors
     * @return bool
     */
    public function validateUser(UserInterface $user, &$errors)
    {
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $result = array();
            foreach ($errors as $error) {
                $result[] = sprintf('%s: %s', $error->getInvalidValue(), $error->getMessage());
            }

            return false;
        }

        return true;
    }

    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function updateUser(UserInterface $user)
    {
        $this->updatePassword($user);

        $this->objectManager->persist($user);
    }

    /**
     * @param UserInterface $user
     * @param string $plainPassword
     * @return bool
     */
    public function validatePassword(UserInterface $user, $plainPassword)
    {
        return $this->passwordEncoder->isPasswordValid($user, $plainPassword);
    }

    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));
            $user->eraseCredentials();
        }
    }

    /**
     * @param UserInterface $user
     * @param string $plainPassword
     * @return string
     */
    public function encodePassword(UserInterface $user, $plainPassword)
    {
        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }
}