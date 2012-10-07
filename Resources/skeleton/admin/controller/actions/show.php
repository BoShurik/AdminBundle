
    /**
    * Finds and displays a {{ entity_class }} entity.
    */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('{{ bundle }}:{{ entity_class }}')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity_class }} entity.');
        }

        return $this->render('{{ bundle }}:{{ entity_class|replace({'\\': '/'}) }}:show.html.twig', array(
            'entity'      => $entity
        ));
    }
