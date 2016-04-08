<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:39
 */

namespace BoShurik\AdminBundle\Command\Generate;

use BoShurik\AdminBundle\Command\Command;
use BoShurik\AdminBundle\Generator\Generator;
use BoShurik\AdminBundle\Generator\Interrogator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateControllerCommand extends Command
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Interrogator
     */
    private $interrogator;

    public function __construct($name, Generator $generator, Interrogator $interrogator)
    {
        parent::__construct($name);

        $this->generator = $generator;
        $this->interrogator = $interrogator;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Generate controller for the entity')
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->generator->generate($this->interrogator->getMetadata($this->getQuestionHelper(), $input, $output));
    }

    /**
     * @return \Symfony\Component\Console\Helper\QuestionHelper
     */
    private function getQuestionHelper()
    {
        return $this->getHelper('question');
    }
}