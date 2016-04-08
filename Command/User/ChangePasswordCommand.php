<?php
/**
 * User: boshurik
 * Date: 11.11.15
 * Time: 16:01
 */

namespace BoShurik\AdminBundle\Command\User;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangePasswordCommand extends UserCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password')
            ->setDescription('Changes user password')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $user = $this->getUser($input->getArgument('identifier-field'), $input->getArgument('identifier'));
        $plainPassword = $this->userManager->setPassword($user, $input->getOption('password'));
        $this->updateUser($user);
        $this->io->writeln(sprintf('Password for user <info>%s</info> has been changed to <info>%s</info>', $input->getArgument('identifier'), $plainPassword));
    }
}