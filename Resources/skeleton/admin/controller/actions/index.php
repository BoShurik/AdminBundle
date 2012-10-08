
    /**
    * Lists all {{ entity_class }} entities.
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('{{ bundle }}:{{ entity_path ? (entity_path | join('\\')) ~ '\\' : '' }}{{ entity_class }}')->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($query, $this->get('request')->query->get('page', 1), 10);

        return $this->render('{{ bundle }}:Admin{{ entity_path ? '/' ~ entity_path | join('/') : '' }}/{{ entity_class|replace({'\\': '/'}) }}:index.html.twig', array(
            'entities' => $entities,
        ));
    }
