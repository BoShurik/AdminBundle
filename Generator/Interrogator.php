<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:55
 */

namespace BoShurik\AdminBundle\Generator;

use BoShurik\AdminBundle\Generator\Interrogator\InterrogatorPool;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Interrogator
{
    /**
     * @var InterrogatorPool
     */
    private $interrogatorPool;

    public function __construct(InterrogatorPool $interrogatorPool)
    {
        $this->interrogatorPool = $interrogatorPool;
    }

    /**
     * @param QuestionHelper $questionHelper
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Metadata
     */
    public function getMetadata(QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $metadata = new Metadata();
        
        foreach ($this->interrogatorPool->getInterrogators() as $interrogator) {
            $interrogator->interrogate($metadata, $questionHelper, $input, $output);
        }

        return $metadata;
    }
}