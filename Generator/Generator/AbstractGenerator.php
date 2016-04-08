<?php
/**
 * User: boshurik
 * Date: 20.04.16
 * Time: 18:59
 */

namespace BoShurik\AdminBundle\Generator\Generator;

abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var Renderer
     */
    protected $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
}