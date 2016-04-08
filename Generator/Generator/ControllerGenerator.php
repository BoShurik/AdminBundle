<?php
/**
 * User: boshurik
 * Date: 19.04.16
 * Time: 19:10
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;

class ControllerGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        $path = sprintf('%s/Controller/Admin/%s%sController.php',
            $metadata->getBundle()->getPath(),
            $metadata->getClassPath(),
            $metadata->getClassName()
        );

        $this->renderer->renderFile('Controller/controller.php.twig', $path, array(
            'metadata' => $metadata,
        ));
    }
}