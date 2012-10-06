<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 1:20
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BoShurik\AdminBundle\Entity\Administrator;
use BoShurik\AdminBundle\Form\AdministratorType;

/**
 * Administrator controller.
 *
 */
class AdministratorController extends Controller
{
    /**
     * Lists all Administrator entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BoShurikAdminBundle:Administrator')->createQueryBuilder('a')->getQuery();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->getRequest()->query->get('page', 1), 1);

        return $this->render('BoShurikAdminBundle:Administrator:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Administrator entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BoShurikAdminBundle:Administrator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        return $this->render('BoShurikAdminBundle:Administrator:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to create a new Administrator entity.
     *
     */
    public function newAction()
    {
        $entity = new Administrator();
        $form   = $this->createForm(new AdministratorType(), $entity);

        return $this->render('BoShurikAdminBundle:Administrator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Administrator entity.
     *
     */
    public function createAction()
    {
        $entity  = new Administrator();
        $request = $this->getRequest();
        $form    = $this->createForm(new AdministratorType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $saveAction = $request->request->get('saveAction');
            switch ($saveAction)
            {
                case 'save_list':
                    return $this->redirect($this->generateUrl('admin_administrator'));
                case 'save_new':
                    return $this->redirect($this->generateUrl('admin_administrator_new'));
                default:
                    return $this->redirect($this->generateUrl('admin_administrator_edit', array('id' => $entity->getId())));
            }
        }

        return $this->render('BoShurikAdminBundle:Administrator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Administrator entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BoShurikAdminBundle:Administrator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        $editForm = $this->createForm(new AdministratorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BoShurikAdminBundle:Administrator:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Administrator entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BoShurikAdminBundle:Administrator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        $editForm   = $this->createForm(new AdministratorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $saveAction = $request->request->get('saveAction');
            switch ($saveAction)
            {
                case 'save_list':
                    return $this->redirect($this->generateUrl('admin_administrator'));
                case 'save_new':
                    return $this->redirect($this->generateUrl('admin_administrator_new'));
                default:
                    return $this->redirect($this->generateUrl('admin_administrator_edit', array('id' => $id)));
            }
        }

        return $this->render('BoShurikAdminBundle:Administrator:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Administrator entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BoShurikAdminBundle:Administrator')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Administrator entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_administrator'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }
}
