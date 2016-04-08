<?php
/**
 * User: boshurik
 * Date: 10.04.16
 * Time: 17:49
 */

namespace BoShurik\AdminBundle\Router;

use Symfony\Component\Routing\RouterInterface;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Router
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array
     */
    private $routingMap;

    /**
     * @var bool
     */
    private $initialised;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->initialised = false;
    }

    /**
     * @param string|object $object
     * @param string $action
     * @param int $referenceType
     * @return string
     */
    public function generate($object, $action, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        $class = $this->getClass($object);

        if (!$route = $this->getRoute($class, $action)) {
            $parentClasses = class_parents($class);
            foreach ($parentClasses as $parentClass) {
                if ($route = $this->getRoute($parentClass, $action)) {
                    $class = $parentClass;
                    break;
                }
            }

            if (!$route) {
                throw new RouterException(sprintf('No route for "%s:%s".', $class, $action));
            }
        }

        $name = $this->getRouteName($class, $action);

        $compiledRoute = $route->compile();
        $variables = $compiledRoute->getVariables();

        $parameters = array();
        if (!empty($variables)) {
            $options = $route->getOption('action');
            foreach ($variables as $variable) {
                $entityProperty = isset($options['parameters'][$variable]) ? $options['parameters'][$variable] : $variable;
                $parameters[$variable] = $this->getObjectProperty($object, $entityProperty);
            }
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     * @param $object
     * @param $action
     * @return bool
     */
    public function hasRoute($object, $action)
    {
        $class = $this->getClass($object);

        if (null !== $this->getRouteName($class, $action)) {
            return true;
        }

        $parentClasses = class_parents($class);
        foreach ($parentClasses as $parentClass) {
            if (null !== $this->getRouteName($parentClass, $action)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $class
     * @param string $action
     * @return string
     */
    private function getRouteName($class, $action)
    {
        $this->initialise();

        if (!isset($this->routingMap[$class])) {
            return null;
        }

        if (!isset($this->routingMap[$class][$action])) {
            return null;
        }

        return $this->routingMap[$class][$action];
    }

    /**
     * @param $class
     * @param $action
     * @return null|\Symfony\Component\Routing\Route
     */
    private function getRoute($class, $action)
    {
        if (!$name = $this->getRouteName($class, $action)) {
            return null;
        }

        return $this->router->getRouteCollection()->get($name);
    }

    /**
     * Initialise routing map
     */
    private function initialise()
    {
        if ($this->initialised) {
            return;
        }

        foreach ($this->router->getRouteCollection()->all() as $name => $route) {
            if (false === $route->hasOption('action')) {
                continue;
            }

            $options = $route->getOption('action');

            if (empty($options['class'])) {
                throw new RouterException(sprintf('Missing "class" option in route "%s".', $name));
            }
            if (empty($options['name'])) {
                throw new RouterException(sprintf('Missing "name" option in route "%s".', $name));
            }

            $this->routingMap[$options['class']][$options['name']] = $name;
        }

        $this->initialised = true;
    }

    /**
     * @param object $object
     * @param string $property
     * @return mixed
     */
    private function getObjectProperty($object, $property)
    {
        $value = $object;
        $parts = explode('.', $property);

        foreach ($parts as $part) {
            $method = sprintf('get%s', ucfirst($part));
            if (is_object($value) && method_exists($value, $method)) {
                $value = $value->$method();
            } else {
                throw new RouterException(sprintf('Unknown method "%s"', $property));
            }
        }

        return $value;
    }

    /**
     * @param string|object $object
     * @return string
     */
    private function getClass($object)
    {
        if (is_object($object)) {
            return ClassUtils::getClass($object);
        } else {
            return $object;
        }
    }
}