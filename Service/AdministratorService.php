<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 0:34
 */

namespace BoShurik\AdminBundle\Service;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Security\Core\User\UserInterface;
use BoShurik\AdminBundle\Entity\Administrator;

class AdministratorService
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EntityManager $em, EncoderFactoryInterface $encoderFactory)
    {
        $this->em = $em;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @return \BoShurik\AdminBundle\Entity\Administrator
     */
    public function create()
    {
        $administrator = new Administrator();

        return $administrator;
    }

    /**
     * @param \BoShurik\AdminBundle\Entity\Administrator $administrator
     * @param bool $andFlush
     */
    public function update(Administrator $administrator, $andFlush = false)
    {
        $this->updatePassword($administrator);

        $this->em->persist($administrator);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param \BoShurik\AdminBundle\Entity\Administrator $administrator
     */
    public function updatePassword(Administrator $administrator)
    {
        if (0 !== strlen($password = $administrator->getPlainPassword())) {
            $encoder = $this->getEncoder($administrator);
            $administrator->setPassword($encoder->encodePassword($password, $administrator->getSalt()));
            $administrator->eraseCredentials();
        }
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface
     */
    private function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }
}
