<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:31
 */

namespace BoShurik\AdminBundle\Generator;

use BoShurik\AdminBundle\Generator\Generator\GeneratorPool;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Generator
{
    /**
     * @var GeneratorPool
     */
    private $generatorPool;

    public function __construct(GeneratorPool $generatorPool)
    {
        $this->generatorPool = $generatorPool;
    }

    public function generate(Metadata $metadata, OutputInterface $output = null)
    {
        if (!$output) {
            $output = new NullOutput();
        }

        foreach ($this->generatorPool->getGenerators() as $generator) {
            $generator->generate($metadata, $output);
        }
    }
}