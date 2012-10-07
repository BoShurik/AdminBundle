
    /**
    * Deletes a {{ entity_class }} entity.
    */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('{{ bundle }}:{{ entity_class }}')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find {{ entity_class }} entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('{{ route_name_prefix }}'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
