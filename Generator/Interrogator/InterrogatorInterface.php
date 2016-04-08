<?php
/**
 * User: boshurik
 * Date: 21.04.16
 * Time: 18:54
 */

namespace BoShurik\AdminBundle\Generator\Interrogator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface InterrogatorInterface
{
    /**
     * @param Metadata $metadata
     * @param QuestionHelper $questionHelper
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output);
}