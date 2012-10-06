<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 0:44
 */

namespace BoShurik\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use BoShurik\AdminBundle\Service\AdministratorService;

class CreateAdministratorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('boshurik:administrator:create')
            ->setDescription('Create administrator')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $administratorService = $this->getAdministratorService();

        $administrator = $administratorService->create();
        $administrator->setUsername($username);
        $administrator->setEmail($email);
        $administrator->setPlainPassword($password);

        $administratorService->update($administrator, true);

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

    /**
     * @return \BoShurik\AdminBundle\Service\AdministratorService
     */
    private function getAdministratorService()
    {
        return $this->getContainer()->get('boshurik_admin.administrator_service');
    }
}
