<?php
/**
 * User: boshurik
 * Date: 21.04.16
 * Time: 18:53
 */

namespace BoShurik\AdminBundle\Generator\Interrogator;

class InterrogatorPool
{
    /**
     * @var InterrogatorInterface[]
     */
    private $interrogators;

    public function __construct()
    {
        $this->interrogators = array();
    }

    /**
     * @return InterrogatorInterface[]
     */
    public function getInterrogators()
    {
        return $this->interrogators;
    }

    /**
     * @param InterrogatorInterface $interrogator
     */
    public function addInterrogator(InterrogatorInterface $interrogator)
    {
        $this->interrogators[] = $interrogator;
    }
}