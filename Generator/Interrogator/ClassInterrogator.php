<?php
/**
 * User: boshurik
 * Date: 21.04.16
 * Time: 18:54
 */

namespace BoShurik\AdminBundle\Generator\Interrogator;

use Symfony\Bridge\Doctrine\RegistryInterface;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ClassInterrogator implements InterrogatorInterface
{
    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * @var RegistryInterface
     */
    private $doctrineMongoDB;

    public function __construct(RegistryInterface $doctrine = null, RegistryInterface $doctrineMongoDB = null)
    {
        $this->doctrine = $doctrine;
        $this->doctrineMongoDB = $doctrineMongoDB;

        if (!$this->doctrine && !$this->doctrineMongoDB) {
            throw new \LogicException('No doctrine');
        }
    }

    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $question = new ChoiceQuestion('<question>Object class</question>: ', $this->getClasses());
        $class = $questionHelper->ask($input, $output, $question);

        $metadata->setClass($this->getClassMetadata($class));
    }

    /**
     * @return array
     */
    private function getClasses()
    {
        $classes = array();

        if ($this->doctrine) {
            foreach ($this->doctrine->getManagers() as $manager) {
                foreach ($manager->getMetadataFactory()->getAllMetadata() as $meta) {
                    $classes[] = $meta->getName();
                }
            }
        }

        if ($this->doctrineMongoDB) {
            foreach ($this->doctrineMongoDB->getManagers() as $manager) {
                foreach ($manager->getMetadataFactory()->getAllMetadata() as $meta) {
                    $classes[] = $meta->getName();
                }
            }
        }

        return $classes;
    }

    /**
     * @param string $class
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    private function getClassMetadata($class)
    {
        if ($this->doctrine) {
            if ($manager = $this->doctrine->getManagerForClass($class)) {
                return $manager->getClassMetadata($class);
            }
        }

        if ($this->doctrineMongoDB) {
            if ($manager = $this->doctrineMongoDB->getManagerForClass($class)) {
                return $manager->getClassMetadata($class);
            }
        }

        throw new \LogicException(sprintf('Can\'t find metadata for "%s" class'));
    }
}