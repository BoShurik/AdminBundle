<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 18:24
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Action\ShowActionTrait;
use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowActionInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        if (!in_array(Metadata::ACTION_SHOW, $metadata->getActions())) {
            return;
        }

        $metadata->addControllerTrait(ShowActionTrait::class);
    }
}