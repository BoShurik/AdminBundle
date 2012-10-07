
    /**
    * Displays a form to create a new {{ entity_class }} entity.
    */
    public function newAction()
    {
        $entity = new {{ entity_class }}();
        $form   = $this->createForm(new {{ entity_class }}Type(), $entity);

        return $this->render('{{ bundle }}:Admin/{{ entity_class|replace({'\\': '/'}) }}:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
