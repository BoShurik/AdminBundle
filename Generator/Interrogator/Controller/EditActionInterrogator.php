<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 18:25
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Action\EditActionTrait;
use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditActionInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        if (!in_array(Metadata::ACTION_EDIT, $metadata->getActions())) {
            return;
        }

        $metadata->addControllerTrait(EditActionTrait::class);
    }
}