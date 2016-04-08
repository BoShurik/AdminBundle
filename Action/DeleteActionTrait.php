<?php
/**
 * User: boshurik
 * Date: 29.02.16
 * Time: 17:45
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

trait DeleteActionTrait
{
    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function deleteAction(Request $request, $id)
    {
        $object = $this->getObject($id);

        $form = $this->createDeleteForm($object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->deleteObject($object);

            return $this->redirectToAction($object, 'list');
        }

        if (method_exists($this, 'getShowRouteName')) {
            return $this->redirectToAction($object, 'show');
        }

        return $this->redirectToAction($object, 'list');
    }

    /**
     * @param object $object
     * @param array $options
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    protected function createDeleteForm($object, array $options = array())
    {
        $form = $this->createNamedForm(
            sprintf('delete_%s', preg_replace('/[^\.\:\_\-\d\w]+/', '', $object->getId())),
            FormType::class,
            array(
                'id' => $object->getId(),
            ),
            array_merge(array(
                'action' => $this->generateActionUrl($object, 'delete'),
            ), $options)
        );
        $form->add('id', HiddenType::class);

        return $form;
    }

    /**
     * @param object $object
     */
    abstract protected function deleteObject($object);

    /**
     * @param integer $id
     * @return object
     */
    abstract protected function getObject($id);

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
     * Creates form with given name
     *
     * @param string $name
     * @param string $type
     * @param null $data
     * @param array $options
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    abstract protected function createNamedForm($name, $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = array());
}