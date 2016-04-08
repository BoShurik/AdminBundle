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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class AdministratorFilterType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, array(
                'label' => 'controller.admin.administrator.id',
            ))
            ->add('enabled', ChoiceType::class, array(
                'choices'  => array(
                    'interface.yes' => true,
                    'interface.no' => false,
                ),
                'choices_as_values' => true,
                'required' => false,
                'placeholder' => 'controller.admin.administrator.enabled',
            ))
            ->add('locked', ChoiceType::class, array(
                'choices'  => array(
                    'interface.yes' => true,
                    'interface.no' => false,
                ),
                'choices_as_values' => true,
                'required' => false,
                'placeholder' => 'controller.admin.administrator.locked',
            ))
            ->add('email', TextType::class, array(
                'label' => 'controller.admin.administrator.email',
            ))
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'required' => false,
            'csrf_protection' => false,
            'translation_domain' => 'BoShurikAdminBundle',
        ));
    }
}