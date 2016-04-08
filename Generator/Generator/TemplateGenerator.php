<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 21:36
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        $path = sprintf('%s/Resources/views/Admin/%s%s',
            $metadata->getBundle()->getPath(),
            $metadata->getClassPath(),
            $metadata->getClassName()
        );

        if (in_array(Metadata::ACTION_LIST, $metadata->getActions())) {
            $this->generateListAction($metadata, $path);
        }
        if (in_array(Metadata::ACTION_CREATE, $metadata->getActions())) {
            $this->generateCreateAction($metadata, $path);
        }
        if (in_array(Metadata::ACTION_SHOW, $metadata->getActions())) {
            $this->generateShowAction($metadata, $path);
        }
        if (in_array(Metadata::ACTION_EDIT, $metadata->getActions())) {
            $this->generateEditAction($metadata, $path);
        }
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateListAction(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Template/list.twig.twig', sprintf('%s/list.html.twig', $path), array(
            'metadata' => $metadata,
        ));
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateCreateAction(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Template/create.twig.twig', sprintf('%s/create.html.twig', $path), array(
            'metadata' => $metadata,
        ));
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateShowAction(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Template/show.twig.twig', sprintf('%s/show.html.twig', $path), array(
            'metadata' => $metadata,
        ));
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateEditAction(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Template/edit.twig.twig', sprintf('%s/edit.html.twig', $path), array(
            'metadata' => $metadata,
        ));
    }
}