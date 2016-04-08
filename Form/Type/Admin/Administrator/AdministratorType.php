<?php
/**
 * User: boshurik
 * Date: 10.04.16
 * Time: 19:25
 */

namespace BoShurik\AdminBundle\Form\Type\Admin\Administrator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\Admin\Administrator;

class AdministratorType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', null, array(
                'label' => 'controller.admin.administrator.enabled',
            ))
            ->add('locked', null, array(
                'label' => 'controller.admin.administrator.locked',
            ))
            ->add('email', null, array(
                'label' => 'controller.admin.administrator.email',
            ))
            ->add('plainPassword', null, array(
                'label' => 'controller.admin.administrator.password',
            ))
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Administrator::class,
            'translation_domain' => 'BoShurikAdminBundle',
        ));
    }
}