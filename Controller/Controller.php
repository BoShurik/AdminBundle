<?php
/**
 * User: boshurik
 * Date: 08.04.16
 * Time: 17:31
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';

    /**
     * @param string $message
     */
    protected function addSuccessFlashMessage($message = 'Форма отправлена')
    {
        $this->addFlash(self::FLASH_SUCCESS, $message);
    }

    /**
     * @param string $message
     */
    protected function addErrorFlashMessage($message = 'Произошла ошибка')
    {
        $this->addFlash(self::FLASH_ERROR, $message);
    }

    /**
     * Creates form with given name
     *
     * @param string $name
     * @param string $type
     * @param null $data
     * @param array $options
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    protected function createNamedForm($name, $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = array())
    {
        return $this->get('form.factory')->createNamed($name, $type, $data, $options);
    }
}