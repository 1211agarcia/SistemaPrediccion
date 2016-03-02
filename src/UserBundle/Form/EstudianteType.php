<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudianteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('cedula')
            ->add('notaPrimero')
            ->add('notaSegundo')
            ->add('notaTercero')
            ->add('notaCuarto')
            ->add('cantMaterias')
            ->add('promedio')
            ->add('primeraOpcionOpsu')
            ->add('segundaOpcionOpsu')
            ->add('sexo')
            ->add('tieneAccesoInternet')
            ->add('esAsignadoOPSU', 'checkbox',
                array(
                    'label'    => '¿Es asigMostrar públicamente?',
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'checkbox-inline','data-on-text'=> 'Sí','data-off-text'=> 'No'),
                    'required' => false,
                )
            )
            ->add('gestionPlantel')
            ->add('tipoPlantel')
            ->add('nivelSocioeconomico')
            ->add('nivelEstudioPadres')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Estudiante'
        ));
    }

    public function getParent()
    {
        return 'user_registration';
    }

    public function getName()
    {
        return 'estudiante_registration';
    }
}
