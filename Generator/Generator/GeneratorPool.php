<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:32
 */

namespace BoShurik\AdminBundle\Generator\Generator;


class GeneratorPool
{
    /**
     * @var GeneratorInterface[]
     */
    private $generators;

    public function __construct()
    {
        $this->generators = array();
    }

    /**
     * @return GeneratorInterface[]
     */
    public function getGenerators()
    {
        return $this->generators;
    }

    /**
     * @param GeneratorInterface $generator
     */
    public function addGenerator(GeneratorInterface $generator)
    {
        $this->generators[] = $generator;
    }
}