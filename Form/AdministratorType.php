<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 1:23
 */

namespace BoShurik\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled')
            ->add('expired')
            ->add('locked')
            ->add('username')
            ->add('plainPassword')
            ->add('name')
            ->add('email')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BoShurik\AdminBundle\Entity\Administrator'
        ));
    }

    public function getName()
    {
        return 'boshurik_adminbundle_administratortype';
    }
}
