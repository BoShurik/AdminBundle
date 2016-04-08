<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:32
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;

interface GeneratorInterface
{
    /**
     * @param Metadata $metadata
     * @param OutputInterface $output
     * @return mixed
     */
    public function generate(Metadata $metadata, OutputInterface $output);
}