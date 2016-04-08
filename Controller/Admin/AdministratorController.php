<?php
/**
 * User: boshurik
 * Date: 09.04.16
 * Time: 22:00
 */

namespace BoShurik\AdminBundle\Controller\Admin;

use BoShurik\AdminBundle\Controller\AbstractActionController;
use BoShurik\AdminBundle\Admin\SidebarInterface;

use BoShurik\AdminBundle\Action\ListActionTrait;
use BoShurik\AdminBundle\Action\ShowActionTrait;
use BoShurik\AdminBundle\Action\CreateActionTrait;
use BoShurik\AdminBundle\Action\EditActionTrait;
use BoShurik\AdminBundle\Action\DeleteActionTrait;
use BoShurik\AdminBundle\Action\SidebarTrait;

use BoShurik\AdminBundle\Model\AbstractAdministrator;

class AdministratorController extends AbstractActionController implements SidebarInterface
{
    use ListActionTrait;
    use ShowActionTrait;
    use CreateActionTrait;
    use EditActionTrait;
    use DeleteActionTrait {
        createDeleteForm as traitCreateDeleteForm;
    }
    use SidebarTrait;

    /**
     * @inheritDoc
     */
    public function getSidebarName()
    {
        return 'controller.admin.administrator._interface.menu';
    }

    /**
     * @inheritDoc
     */
    protected function deleteObject($object)
    {
        if ($this->getUser()->getId() == $object->getId()) {
            throw $this->createAccessDeniedException();
        }

        parent::deleteObject($object);
    }

    /**
     * @inheritDoc
     */
    protected function createDeleteForm($object, array $options = array())
    {
        if ($this->getUser()->getId() == $object->getId()) {
            return null;
        }

        return $this->traitCreateDeleteForm($object, $options);
    }

    /**
     * @inheritDoc
     */
    protected function getObjectClass()
    {
        return $this->getParameter('bo_shurik_admin.administrator.class');
    }

    /**
     * @inheritDoc
     */
    protected function createObjectForm($object = null, array $options = array())
    {
        return $this->createForm($this->getParameter('bo_shurik_admin.administrator.form_type'), $object, $options);
    }

    /**
     * @inheritDoc
     */
    protected function createFilterForm(array $data = null, array $options = array())
    {
        return $this->createNamedForm('f', $this->getParameter('bo_shurik_admin.administrator.filter_type'), $data, $options);
    }

    /**
     * @inheritDoc
     */
    protected function persistObject($object)
    {
        /** @var AbstractAdministrator $object */
        $this->getUserManager()->updateUser($object);

        parent::persistObject($object);
    }

    /**
     * @return \BoShurik\AdminBundle\Administrator\UserManager
     */
    private function getUserManager()
    {
        return $this->get('bo_shurik_admin.administrator.manager');
    }
}