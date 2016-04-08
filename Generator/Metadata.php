<?php
/**
 * User: boshurik
 * Date: 14.04.16
 * Time: 18:30
 */

namespace BoShurik\AdminBundle\Generator;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class Metadata extends \ArrayObject
{
    const FIELD_CLASS                   = 'class';
    const FIELD_BUNDLE                  = 'bundle';
    const FIELD_ACTIONS                 = 'actions';
    const FIELD_CONTROLLER_TRAITS       = 'controller_traits';
    const FIELD_CONTROLLER_METHODS      = 'controller_methods';
    const FIELD_CONTROLLER_INTERFACES   = 'controller_interfaces';
    const FIELD_FILTER                  = 'filter';
    const FIELD_ROUTING_PREFIX          = 'routing_prefix';

    const ACTION_LIST                   = 'list';
    const ACTION_SHOW                   = 'show';
    const ACTION_CREATE                 = 'create';
    const ACTION_EDIT                   = 'edit';
    const ACTION_DELETE                 = 'delete';

    /**
     * @return string
     */
    public function getClassFQN()
    {
        return $this->getClass()->getName();
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        $parts = $this->getClassParts();

        $name = end($parts);

        return $name;
    }

    /**
     * @return string
     */
    public function getClassPath()
    {
        $parts = array_slice($this->getClassParts(), 0, -1);
        if (empty($parts)) {
            return '';
        }

        return implode('/', $parts) . '/';
    }

    /**
     * @return mixed
     */
    public function getClassNamespace()
    {
        $parts = array_slice($this->getClassParts(), 0, -1);
        if (empty($parts)) {
            return '';
        }

        return '\\' . implode('\\', $parts);
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function getPrefix($delimiter = '_')
    {
        $parts = $this->getClassParts();
        $parts = array_map(function($value){
            return Container::underscore($value);
        }, $parts);

        return implode($delimiter, $parts);
    }

    /**
     * @return array
     */
    public function getClassParts()
    {
        $class = $this->getClassFQN();
        $relativeClassName = str_replace($this->getBundle()->getNamespace() .'\\', '', $class);

        $parts = array_slice(explode('\\', $relativeClassName), 1);

        return $parts;
    }

    /**
     * @return bool
     */
    public function hasClass()
    {
        return isset($this[self::FIELD_CLASS]);
    }

    /**
     * @return ClassMetadata
     */
    public function getClass()
    {
        return $this->hasClass() ? $this[self::FIELD_CLASS] : null;
    }

    /**
     * @param ClassMetadata $class
     */
    public function setClass($class)
    {
        $this[self::FIELD_CLASS] = $class;
    }

    /**
     * @return bool
     */
    public function hasBundle()
    {
        return isset($this[self::FIELD_BUNDLE]);
    }

    /**
     * @return BundleInterface
     */
    public function getBundle()
    {
        return $this->hasBundle() ? $this[self::FIELD_BUNDLE] : null;
    }

    /**
     * @param BundleInterface $bundle
     */
    public function setBundle($bundle)
    {
        $this[self::FIELD_BUNDLE] = $bundle;
    }

    /**
     * @return bool
     */
    public function hasActions()
    {
        return isset($this[self::FIELD_ACTIONS]);
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->hasActions() ? $this[self::FIELD_ACTIONS] : null;
    }

    /**
     * @param array $actions
     */
    public function setActions($actions)
    {
        $this[self::FIELD_ACTIONS] = $actions;
    }

    /**
     * @return bool
     */
    public function hasControllerTraits()
    {
        return isset($this[self::FIELD_CONTROLLER_TRAITS]);
    }

    /**
     * @return array
     */
    public function getControllerTraits()
    {
        return $this->hasControllerTraits() ? $this[self::FIELD_CONTROLLER_TRAITS] : array();
    }

    /**
     * @param array $traits
     */
    public function setControllerTraits($traits)
    {
        $this[self::FIELD_CONTROLLER_TRAITS] = $traits;
    }

    /**
     * @param string $trait
     */
    public function addControllerTrait($trait)
    {
        $this[self::FIELD_CONTROLLER_TRAITS][] = $trait;
    }

    /**
     * @return bool
     */
    public function hasControllerMethods()
    {
        return isset($this[self::FIELD_CONTROLLER_METHODS]);
    }

    /**
     * @return array
     */
    public function getControllerMethods()
    {
        return $this->hasControllerMethods() ? $this[self::FIELD_CONTROLLER_METHODS] : array();
    }

    /**
     * @param array $methods
     */
    public function setControllerMethods($methods)
    {
        $this[self::FIELD_CONTROLLER_METHODS] = $methods;
    }

    /**
     * @param string $method
     */
    public function addControllerMethod($method)
    {
        $this[self::FIELD_CONTROLLER_METHODS][] = $method;
    }

    /**
     * @return bool
     */
    public function hasControllerInterfaces()
    {
        return isset($this[self::FIELD_CONTROLLER_INTERFACES]);
    }

    /**
     * @return array
     */
    public function getControllerInterfaces()
    {
        return $this->hasControllerInterfaces() ? $this[self::FIELD_CONTROLLER_INTERFACES] : array();
    }

    /**
     * @param array $methods
     */
    public function setControllerInterfaces($methods)
    {
        $this[self::FIELD_CONTROLLER_INTERFACES] = $methods;
    }

    /**
     * @param string $method
     */
    public function addControllerInterface($method)
    {
        $this[self::FIELD_CONTROLLER_INTERFACES][] = $method;
    }

    /**
     * @return bool
     */
    public function hasFilter()
    {
        return isset($this[self::FIELD_FILTER]);
    }

    /**
     * @return bool
     */
    public function getFilter()
    {
        return $this->hasFilter() ? $this[self::FIELD_FILTER] : false;
    }

    /**
     * @param bool $filter
     */
    public function setFilter($filter)
    {
        $this[self::FIELD_FILTER] = $filter;
    }

    /**
     * @return bool
     */
    public function hasRoutingPrefix()
    {
        return isset($this[self::FIELD_ROUTING_PREFIX]);
    }

    /**
     * @return string|null
     */
    public function getRoutingPrefix()
    {
        return $this->hasRoutingPrefix() ? $this[self::FIELD_ROUTING_PREFIX] : null;
    }

    /**
     * @param string $routingPrefix
     */
    public function setRoutingPrefix($routingPrefix)
    {
        $this[self::FIELD_ROUTING_PREFIX] = $routingPrefix;
    }
}