<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 18:24
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Action\CreateActionTrait;
use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateActionInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        if (!in_array(Metadata::ACTION_CREATE, $metadata->getActions())) {
            return;
        }

        $metadata->addControllerTrait(CreateActionTrait::class);
        $metadata->addControllerMethod('Controller/methods/create_object_form.php.twig');
    }
}