<?php

namespace {{ namespace }}\Controller\Admin{{ entity_namespace ? '\\' ~ entity_namespace : '' }};

use BoShurik\AdminBundle\Controller\Controller;

use {{ namespace }}\Entity{{ entity_namespace ? '\\' ~ entity_namespace : '' }}\{{ entity_class }};
use {{ namespace }}\Form\Admin{{ entity_namespace ? '\\' ~ entity_namespace : '' }}\{{ entity_class }}Type;

/**
 * {{ entity_class }} controller.
 */
class {{ entity_class }}Controller extends Controller
{

    {%- include 'controller/actions/index.php' %}


    {%- include 'controller/actions/show.php' %}


    {%- include 'controller/actions/new.php' %}


    {%- include 'controller/actions/create.php' %}


    {%- include 'controller/actions/edit.php' %}


    {%- include 'controller/actions/update.php' %}


    {%- include 'controller/actions/delete.php' %}

    /**
     * {@inheritDoc}
     */
    public function getNewLink()
    {
        return $this->generateUrl('{{ route_name_prefix }}_new');
    }

    /**
     * {@inheritDoc}
     */
    public function getListLink()
    {
        return $this->generateUrl('{{ route_name_prefix }}');
    }

    /**
     * {@inheritDoc}
     */
    public function getActionsLinks()
    {
        return array();
    }
}