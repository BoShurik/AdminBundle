<?php
/**
 * User: boshurik
 * Date: 01.05.16
 * Time: 1:25
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;

class FormGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        if (count(array_intersect($metadata->getActions(), array(Metadata::ACTION_CREATE, Metadata::ACTION_EDIT, Metadata::ACTION_LIST))) == 0){
            return;
        }

        $path = sprintf('%s/Form/Type/Admin/%s%s',
            $metadata->getBundle()->getPath(),
            $metadata->getClassPath(),
            $metadata->getClassName()
        );

        if (count(array_intersect($metadata->getActions(), array(Metadata::ACTION_CREATE, Metadata::ACTION_EDIT))) > 0){
            $this->generateObjectType($metadata, $path);
        }

        if ($metadata->getFilter()){
            $this->generateObjectFilterType($metadata, $path);
        }
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateObjectType(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Form/object_type.php.twig', sprintf('%s/%sType.php', $path, $metadata->getClassName()), array(
            'metadata' => $metadata,
        ));
    }

    /**
     * @param Metadata $metadata
     * @param string $path
     */
    private function generateObjectFilterType(Metadata $metadata, $path)
    {
        $this->renderer->renderFile('Form/object_filter_type.php.twig', sprintf('%s/%sFilterType.php', $path, $metadata->getClassName()), array(
            'metadata' => $metadata,
        ));
    }
}