<?php
/**
 * User: boshurik
 * Date: 29.02.16
 * Time: 17:45
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait EditActionTrait
{
    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $parameters = $this->getEditActionParameters($request, $id);
        if ($parameters instanceof Response) {
            return $parameters;
        }

        return $this->render($this->getTemplate('edit.html.twig'), $parameters);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function getEditActionParameters(Request $request, $id)
    {
        $object = $this->getObject($id);
        $form = $this->createObjectForm($object, array(
            'action' => $this->generateActionUrl($object, 'edit'),
            'method' => 'POST',
            'validation_groups' => array('Default', 'edit'),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->persistObject($object);

                return $this->redirectToAction($object, 'edit');
            }
        }

        $parameters = array(
            'object' => $object,
            'form' => $form->createView(),
        );

        $deleteForm = null;
        if (method_exists($this, 'createDeleteForm')) {
            /** @var Form|null $deleteForm */
            $deleteForm = $this->createDeleteForm($object);
            $parameters['delete_form'] = $deleteForm ? $deleteForm->createView() : null;
        }

        return $parameters;
    }

    /**
     * @param object $object
     */
    abstract protected function persistObject($object);

    /**
     * @param integer $id
     * @return object
     */
    abstract protected function getObject($id);

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