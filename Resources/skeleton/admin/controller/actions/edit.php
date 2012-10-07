
    /**
    * Displays a form to edit an existing {{ entity_class }} entity.
    */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('{{ bundle }}:{{ entity_class }}')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity_class }} entity.');
        }

        $editForm = $this->createForm(new {{ entity_class }}Type(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('{{ bundle }}:{{ entity_class|replace({'\\': '/'}) }}:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
