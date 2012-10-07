<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 17:38
 */

namespace BoShurik\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\Bundle\DoctrineBundle\Mapping\MetadataFactory;

use BoShurik\AdminBundle\Generator\AdminGenerator;

class GenerateAdminCommand extends ContainerAwareCommand
{
    /**
     * @var \BoShurik\AdminBundle\Generator\AdminGenerator $generator
     */
    private $generator;

    protected function configure()
    {
        $this
            ->setName('boshurik:admin:generate')
            ->setDescription('Create admin controller')
            ->setDefinition(array(
                new InputOption('entity', '', InputOption::VALUE_REQUIRED, 'The entity class name to initialize (shortcut notation)'),
                new InputOption('route-prefix', '', InputOption::VALUE_REQUIRED, 'The route prefix'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('execute');

        $entity = $input->getOption('entity');
        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        $prefix = $this->getRoutePrefix($input, $entity);

        $entityClass = $this->getContainer()->get('doctrine')->getEntityNamespace($bundle).'\\'.$entity;
        $metadata    = $this->getEntityMetadata($entityClass);
        $bundle      = $this->getContainer()->get('kernel')->getBundle($bundle);

        $generator = $this->getGenerator();
        $generator->generate($bundle, $entity, $metadata[0], $prefix);

        $output->writeln('Please integrate admin.yml and routing_admin.yml to your project manually');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('interact');

        $dialog = $this->getHelper('dialog');

        $defaultEntity = $input->getOption('entity');
        $entity = $dialog->askAndValidate($output, sprintf('Entity: [%s] ', $defaultEntity), function($value) {
            return $value;
        }, 10, $defaultEntity);

        $input->setOption('entity', $entity);

        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        // Route Prefix
        $defaultPrefix = $this->getRoutePrefix($input, $entity);
        $prefix = $dialog->askAndValidate($output, sprintf('Route Prefix: [%s] ', $defaultPrefix), function($value) {
            return $value;
        }, 10, $defaultPrefix);

        $input->setOption('route-prefix', $prefix);
    }

    /**
     * @see Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCommand
     *
     * @param $shortcut
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function parseShortcutNotation($shortcut)
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':')) {
            throw new \InvalidArgumentException(sprintf('The entity name must contain a : ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)', $entity));
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }

    /**
     * @see Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCommand
     *
     * @param $entity
     * @return array
     */
    protected function getEntityMetadata($entity)
    {
        $factory = new MetadataFactory($this->getContainer()->get('doctrine'));

        return $factory->getClassMetadata($entity)->getMetadata();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param $entity
     * @return string
     */
    protected function getRoutePrefix(InputInterface $input, $entity)
    {
        $prefix = $input->getOption('route-prefix') ?: strtolower(str_replace(array('\\', '/'), '_', $entity));

        if ($prefix && '/' === $prefix[0]) {
            $prefix = substr($prefix, 1);
        }

        return $prefix;
    }

    /**
     * @return \BoShurik\AdminBundle\Generator\AdminGenerator
     */
    protected function getGenerator()
    {
        if (null === $this->generator) {
            $this->generator = new AdminGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/admin');
        }

        return $this->generator;
    }
}
