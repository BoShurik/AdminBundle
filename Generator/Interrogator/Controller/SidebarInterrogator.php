<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 18:25
 */

namespace BoShurik\AdminBundle\Generator\Interrogator\Controller;

use BoShurik\AdminBundle\Action\SidebarTrait;
use BoShurik\AdminBundle\Admin\SidebarInterface;
use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorInterface;
use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SidebarInterrogator implements InterrogatorInterface
{
    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $metadata->addControllerInterface(SidebarInterface::class);
        $metadata->addControllerTrait(SidebarTrait::class);
        $metadata->addControllerMethod('Controller/methods/get_sidebar_name.php.twig');
    }
}