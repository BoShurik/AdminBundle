<?php
/**
 * User: boshurik
 * Date: 21.04.16
 * Time: 18:54
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ActionsInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $defaults = implode(',', $this->getActions());
        $question = new ChoiceQuestion(sprintf('<question>Actions</question> [%s]:', $defaults), $this->getActions(), $defaults);
        $question->setMultiselect(true);

        $metadata->setActions($questionHelper->ask($input, $output, $question));
    }

    private function getActions()
    {
        return array(
            Metadata::ACTION_LIST,
            Metadata::ACTION_SHOW,
            Metadata::ACTION_CREATE,
            Metadata::ACTION_EDIT,
            Metadata::ACTION_DELETE,
        );
    }
}