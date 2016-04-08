<?php
/**
 * User: boshurik
 * Date: 11.11.15
 * Time: 16:17
 */

namespace BoShurik\AdminBundle\Command\User;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LockCommand extends UserCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('unlock', 'u', InputOption::VALUE_NONE)
            ->setDescription('Locks\\unlocks user')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $user = $this->getUser($input->getArgument('identifier-field'), $input->getArgument('identifier'));
        $user->setLocked(!$input->getOption('unlock'));
        $this->updateUser($user);
        $this->io->writeln(sprintf('User <info>%s</info> has been <%3$s>%s</%3$s>',
            $input->getArgument('identifier'),
            $user->isLocked() ? 'locked': 'unlocked',
            $user->isLocked() ? 'error': 'info'
        ));
    }
}