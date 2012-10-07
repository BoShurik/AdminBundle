
    /**
    * Edits an existing {{ entity_class }} entity.
    */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('{{ bundle }}:{{ entity_class }}')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity_class }} entity.');
        }

        $editForm   = $this->createForm(new {{ entity_class }}Type(), $entity);
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
                    return $this->redirect($this->generateUrl('{{ route_name_prefix }}'));
                case 'save_new':
                    return $this->redirect($this->generateUrl('{{ route_name_prefix }}_new'));
                default:
                    return $this->redirect($this->generateUrl('{{ route_name_prefix }}_edit', array('id' => $id)));
            }
        }

        return $this->render('{{ bundle }}:{{ entity_class|replace({'\\': '/'}) }}:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
