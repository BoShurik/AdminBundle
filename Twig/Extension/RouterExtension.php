<?php
/**
 * User: boshurik
 * Date: 10.04.16
 * Time: 18:37
 */

namespace BoShurik\AdminBundle\Twig\Extension;

use BoShurik\AdminBundle\Router\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouterExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('has_action',      array($this, 'hasAction'))
        );
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('action_path', array($this, 'getActionPath')),
            new \Twig_SimpleFunction('action_url',  array($this, 'getActionUrl')),
        );
    }

    /**
     * @param $object
     * @param $action
     * @return bool
     */
    public function hasAction($object, $action)
    {
        return $this->router->hasRoute($object, $action);
    }

    /**
     * @param object $object
     * @param string $action
     * @return string
     */
    public function getActionPath($object, $action)
    {
        return $this->router->generate($object, $action, UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * @param object $object
     * @param string $action
     * @return string
     */
    public function getActionUrl($object, $action)
    {
        return $this->router->generate($object, $action, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'bo_shurik_admin_router';
    }
}