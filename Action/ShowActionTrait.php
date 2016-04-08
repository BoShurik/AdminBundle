<?php
/**
 * User: boshurik
 * Date: 29.02.16
 * Time: 17:45
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait ShowActionTrait
{
    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function showAction(Request $request, $id)
    {
        $parameters = $this->getShowActionParameters($request, $id);
        if ($parameters instanceof Response) {
            return $parameters;
        }

        return $this->render($this->getTemplate('show.html.twig'), $parameters);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    protected function getShowActionParameters(Request $request, $id)
    {
        $object = $this->getObject($id);

        $parameters = array(
            'object' => $object
        );

        if (method_exists($this, 'createDeleteForm')) {
            /** @var Form|null $deleteForm */
            $deleteForm = $this->createDeleteForm($object);
            $parameters['delete_form'] = $deleteForm ? $deleteForm->createView() : null;
        }

        return $parameters;
    }

    /**
     * @param integer $id
     * @return object
     */
    abstract protected function getObject($id);

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
}