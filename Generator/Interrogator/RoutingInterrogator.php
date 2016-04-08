<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 18:07
 */

namespace BoShurik\AdminBundle\Generator\Interrogator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\Container;

class RoutingInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $defaultRoutePrefix = $this->getDefaultRoutingPrefix($metadata);
        $question = new Question(sprintf('<question>Routing prefix</question> [%s]: ', $defaultRoutePrefix), $defaultRoutePrefix);
        $routingPrefix = $questionHelper->ask($input, $output, $question);

        $metadata->setRoutingPrefix($routingPrefix);
    }

    /**
     * @param Metadata $metadata
     * @return string
     */
    private function getDefaultRoutingPrefix(Metadata $metadata)
    {
        $parts = $metadata->getClassParts();
        $parts = array_map(function($value){
            return Container::underscore($value);
        }, $parts);

        return '/' .mb_strtolower(implode('/', $parts));
    }
}