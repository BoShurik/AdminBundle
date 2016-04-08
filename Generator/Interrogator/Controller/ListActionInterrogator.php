<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 18:24
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Action\ListActionTrait;
use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ListActionInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        if (!in_array(Metadata::ACTION_LIST, $metadata->getActions())) {
            return;
        }

        $metadata->addControllerTrait(ListActionTrait::class);

        $filterQuestion = new ConfirmationQuestion('<question>Generate filter?</question> [yes]');
        $metadata->setFilter($questionHelper->ask($input, $output, $filterQuestion));
        if ($metadata->getFilter()) {
            $metadata->addControllerMethod('Controller/methods/create_filter_form.php.twig');
        }
    }
}