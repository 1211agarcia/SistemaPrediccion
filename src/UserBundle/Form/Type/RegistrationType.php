<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RegistrationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*
            ->add('roles', ChoiceType::class,
                array(
                    'label'=>'Rol',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => array(
                        '1' => 'Estudiante',
                        '2' => 'Administrador'),
                    'required' => true,
                )
            )
            */
            //->add('plainPassword', HiddenType::class)
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\usuario',
            'cascade_validation' => true
        ));
    }
    
    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'user_registration';
    }
}