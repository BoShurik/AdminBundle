<?php
/**
 * User: boshurik
 * Date: 29.02.16
 * Time: 17:45
 */

namespace BoShurik\AdminBundle\Action;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait ListActionTrait
{
    /**
     * @param Request $request
     * @param null $parentId
     * @return Response
     */
    public function listAction(Request $request, $parentId = null)
    {
        $parameters = $this->getListActionParameters($request, $parentId);
        if ($parameters instanceof Response) {
            return $parameters;
        }

        $response = null;
        if ($request->query->has('i')) {
            $response = new Response();
            $path = $request->getBaseUrl() . $request->getPathInfo();

            $response->headers->setCookie(
                new Cookie(
                    'items_per_page',
                    $request->query->get('i'),
                    time() + (365 * 24 * 60 * 60),
                    $path
                ));
        }

        return $this->render($this->getTemplate('list.html.twig'), $parameters, $response);
    }

    /**
     * @param Request $request
     * @param null $parentId
     * @return array
     */
    protected function getListActionParameters(Request $request, $parentId = null)
    {
        $filterData = array();
        $filterForm = $this->createFilterForm(null, array(
            'method' => 'GET',
        ));
        if ($filterForm) {
            $filterForm->handleRequest($request);

            if ($filterForm->isSubmitted() && $filterForm->isValid()) {
                $filterData = $filterForm->getData();
            }
        }

        $itemsPerPage = $request->query->get('i', $request->cookies->get('items_per_page', 25));
        $paginate = $this->isPaginationEnabled() && ('all' !== $itemsPerPage);

        $objects = $this->getObjects($parentId, $filterData, null, !$paginate);
        if ($paginate) {
            $objects = $this->getPaginator()->paginate(
                $objects,
                $request->query->get('p', 1),
                (int)$itemsPerPage,
                array(
                    'pageParameterName' => 'p',
                    'itemsPerPage' => $itemsPerPage,
                )
            );
        }

        $parameters = array(
            'objects' => $objects,
            'filter_form' => $filterForm ? $filterForm->createView() : null,
            'paginated' => $paginate,
            'pagination' => $this->isPaginationEnabled(),
        );

        if (method_exists($this, 'createDeleteForm')) {
            $deleteForms = array();
            foreach ($objects as $object) {
                /** @var Form|null $form */
                $form = $this->createDeleteForm($object);
                $deleteForms[$object->getId()] = $form ? $form->createView() : null;
            }

            $parameters['delete_forms'] = $deleteForms;
        }

        return $parameters;
    }

    /**
     * @param null|array $data
     * @param array $options
     * @return \Symfony\Component\Form\Form|null
     */
    abstract protected function createFilterForm(array $data = null, array $options = array());

    /**
     * @return boolean
     */
    abstract protected function isPaginationEnabled();

    /**
     * @param $parentId
     * @param null|array $filterData
     * @param null|array $orderBy
     * @param boolean $all
     * @return mixed
     */
    abstract protected function getObjects($parentId, array $filterData = null, array $orderBy = null, $all = true);

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
     * @return \Knp\Component\Pager\Paginator
     */
    abstract protected function getPaginator();
}