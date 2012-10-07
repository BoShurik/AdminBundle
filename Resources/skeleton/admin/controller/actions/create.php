
    /**
    * Creates a new {{ entity_class }} entity.
    */
    public function createAction()
    {
        $entity  = new {{ entity_class }}();
        $request = $this->getRequest();
        $form    = $this->createForm(new {{ entity_class }}Type(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
                    return $this->redirect($this->generateUrl('{{ route_name_prefix }}_edit', array('id' => $entity->getId())));
            }
        }

        return $this->render('{{ bundle }}:{{ entity_class|replace({'\\': '/'}) }}:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
