<?php
/**
 * User: boshurik
 * Date: 11.11.15
 * Time: 14:55
 */

namespace BoShurik\AdminBundle\Command\User;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class CreateCommand extends UserCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password')
            ->setDescription('Creates user')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $user = $this->userManager->createUser();

        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($user, $input->getArgument('identifier-field'), $input->getArgument('identifier'));

        $plainPassword = $this->userManager->setPassword($user, $input->getOption('password'));

        $errors = null;
        if (!$this->userManager->validateUser($user, $errors)) {
            $this->io->error('Can\'t create user');
            /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $errors */
            /** @var \Symfony\Component\Validator\ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $violation = sprintf('%s (%s): %s', $error->getPropertyPath(), $error->getInvalidValue(), $error->getMessage());
                $this->io->warning($violation);
            }
        } else {
            $this->userManager->updateUser($user);
            $this->getManager()->flush();

            $this->io->writeln(sprintf('User <info>%s</info> with password <info>%s</info> has been created', $input->getArgument('identifier'), $plainPassword));
        }
    }
}