<?php
/**
 * User: boshurik
 * Date: 29.02.16
 * Time: 17:44
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait CreateActionTrait
{
    /**
     * @param Request $request
     * @param null $parentId
     * @return Response
     */
    public function createAction(Request $request, $parentId = null)
    {
        $parameters = $this->getCreateActionParameters($request, $parentId);
        if ($parameters instanceof Response) {
            return $parameters;
        }

        return $this->render($this->getTemplate('create.html.twig'), $parameters);
    }

    /**
     * @param Request $request
     * @param null $parentId
     * @return array|RedirectResponse
     */
    protected function getCreateActionParameters(Request $request, $parentId = null)
    {
        $object = $this->createObject();
        $form = $this->createObjectForm($object, array(
            'action' => $this->generateActionUrl($this->getObjectClass(), 'create'),
            'method' => 'POST',
            'validation_groups' => array('Default', 'create'),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->persistObject($object);

                return $this->redirectToAction($object, 'edit');
            }
        }

        return array(
            'object' => $object,
            'form' => $form->createView(),
        );
    }

    /**
     * Returns object class
     *
     * @return string
     */
    abstract protected function getObjectClass();

    /**
     * @return object
     */
    abstract protected function createObject();

    /**
     * @param object $object
     */
    abstract protected function persistObject($object);

    /**
     * @param null|object $object
     * @param array $options
     * @return \Symfony\Component\Form\Form
     */
    abstract protected function createObjectForm($object = null, array $options = array());

    /**
     * @param string $file
     * @return string
     */
    abstract protected function getTemplate($file);

    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    abstract protected function render($view, array $parameters = array(), Response $response = null);

    /**
     * Returns a RedirectResponse to the given action.
     *
     * @param string|object $object
     * @param string $action
     * @param int $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    abstract protected function redirectToAction($object, $action, $status = 302);

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