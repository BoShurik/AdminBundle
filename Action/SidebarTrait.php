<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 19:49
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait SidebarTrait
{
    /**
     * @return string
     */
    public function getSidebarIndexLink()
    {
        if (!$this->hasAction($this->getObjectClass(), 'list')) {
            return null;
        }

        return $this->generateActionUrl($this->getObjectClass(), 'list');
    }

    /**
     * @return string
     */
    public function getSidebarNewLink()
    {
        if (!$this->hasAction($this->getObjectClass(), 'create')) {
            return null;
        }

        return $this->generateActionUrl($this->getObjectClass(), 'create');
    }

    /**
     * Checks object action
     *
     * @param string|object $object
     * @param string $action
     * @return bool
     */
    abstract protected function hasAction($object, $action);

    /**
     * Returns object class
     *
     * @return string
     */
    abstract protected function getObjectClass();

    /**
     * Generates a URL for action.
     *
     * @param string|object $object         The name of the route
     * @param string        $action         An array of parameters
     * @param int           $referenceType  The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    abstract protected function generateActionUrl($object, $action, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH);
}