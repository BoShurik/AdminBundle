<?php
/**

 * User: boshurik
 * Date: 29.02.16
 * Time: 18:33
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractActionController extends Controller
{
    /**
     * Returns object class
     *
     * @return string
     */
    abstract protected function getObjectClass();

    /**
     * @inheritDoc
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['class'] = $this->getObjectClass();
        
        return parent::render($view, $parameters, $response);
    }

    /**
     * @inheritDoc
     */
    protected function createObject()
    {
        $class = $this->getObjectClass();

        return new $class();
    }

    /**
     * @inheritDoc
     */
    protected function persistObject($object)
    {
        $this->getObjectManager()->persist($object);
        $this->getObjectManager()->flush();
    }

    /**
     * @inheritDoc
     */
    protected function deleteObject($object)
    {
        $this->getObjectManager()->remove($object);
        $this->getObjectManager()->flush();
    }

    /**
     * @inheritDoc
     */
    protected function getObject($id)
    {
        if (!$object = $this->getObjectManager()->getRepository($this->getObjectClass())->find($id)) {
            throw $this->createNotFoundException(sprintf('Object #%s not found', $id));
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    protected function getObjects($parentId, array $filterData = null, array $orderBy = null, $all = true)
    {
        $repository = $this->getObjectManager()->getRepository($this->getObjectClass());

        if (empty($orderBy)) {
            $orderBy = $this->getOrderBy();
        }

        $queryBuilder = $this->getFilterFactoryPool()->createFilter($this->getObjectManager(), $repository)->filter($filterData, $orderBy);
        if ($all) {
            return $queryBuilder->getQuery()->getResult();
        }

        return $queryBuilder;
    }

    /**
     * @param null|array $data
     * @param array $options
     * @return \Symfony\Component\Form\Form|null
     */
    protected function createFilterForm(array $data = null, array $options = array())
    {
        return null;
    }

    /**
     * @return array
     */
    protected function getOrderBy()
    {
        return array(
            'id' => 'DESC',
        );
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->getDoctrine()->getManagerForClass($this->getObjectClass());
    }

    /**
     * @inheritDoc
     */
    protected function isPaginationEnabled()
    {
        return $this->has('knp_paginator');
    }

    /**
     * @inheritDoc
     */
    protected function getTemplate($file)
    {
        return sprintf('%s:%s:%s', $this->getControllerBundle(), implode('/', $this->getControllerPath()), $file);
    }

    /**
     * Checks object action
     *
     * @param string|object $object
     * @param string $action
     * @return bool
     */
    protected function hasAction($object, $action)
    {
        return $this->getActionRouter()->hasRoute($object, $action);
    }

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
    protected function generateActionUrl($object, $action, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->getActionRouter()->generate($object, $action, $referenceType);
    }

    /**
     * Returns a RedirectResponse to the given action.
     *
     * @param string|object $object
     * @param string $action
     * @param int $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToAction($object, $action, $status = 302)
    {
        return $this->redirect($this->generateActionUrl($object, $action), $status);
    }

    /**
     * @return string
     */
    private function getControllerPath()
    {
        $class = get_called_class();
        $controllerPosition = strpos($class, 'Controller');
        $class = str_replace('Controller', '', substr($class, $controllerPosition + 11));

        return explode('\\', $class);
    }

    /**
     * @return string
     */
    private function getControllerBundle()
    {
        $class = get_called_class();
        $bundlePosition = strpos($class, 'Bundle');
        $bundle = str_replace('\\', '', substr($class, 0, $bundlePosition + 6));

        return $bundle;
    }

    /**
     * @inheritDoc
     */
    protected function getPaginator()
    {
        return $this->get('knp_paginator');
    }

    /**
     * @return \BoShurik\AdminBundle\Filter\Factory\FilterFactoryPool
     */
    protected function getFilterFactoryPool()
    {
        return $this->get('bo_shurik_admin.filter.factory_pool');
    }

    /**
     * @return \BoShurik\AdminBundle\Router\Router
     */
    protected function getActionRouter()
    {
        return $this->get('bo_shurik_admin.router');
    }
}