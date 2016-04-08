<?php
/**
 * User: boshurik
 * Date: 11.11.15
 * Time: 16:14
 */

namespace BoShurik\AdminBundle\Command\User;

use AppBundle\Entity\Admin\Administrator;
use BoShurik\AdminBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

use BoShurik\AdminBundle\Administrator\UserManager;
use Doctrine\Common\Persistence\ManagerRegistry;

use BoShurik\AdminBundle\Model\AbstractAdministrator;

abstract class UserCommand extends Command
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @var string
     */
    private $class;

    /**
     * PromoteCommand constructor.
     * @param null|string $name
     * @param UserManager $userManager
     * @param ManagerRegistry $managerRegistry
     * @param $class
     */
    public function __construct($name, UserManager $userManager, ManagerRegistry $managerRegistry, $class)
    {
        parent::__construct($name);

        $this->userManager = $userManager;
        $this->managerRegistry = $managerRegistry;
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->addArgument('identifier-field', InputArgument::REQUIRED, 'User identifier field')
            ->addArgument('identifier', InputArgument::REQUIRED, 'User identifier')
        ;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    protected function getManager()
    {
        return $this->managerRegistry->getManagerForClass($this->class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository($this->class);
    }

    /**
     * @param $field
     * @param $value
     * @return AbstractAdministrator
     */
    protected function getUser($field, $value)
    {
        if (!$user = $this->getRepository()->findOneBy(array(
            $field => $value
        ))) {
            throw new \InvalidArgumentException(sprintf('Can\'t find user "%s"', $value));
        }

        return $user;
    }

    /**
     * @param AbstractAdministrator $user
     */
    protected function updateUser(AbstractAdministrator $user)
    {
        $this->userManager->updateUser($user);
        $this->getManager()->flush();
    }


}