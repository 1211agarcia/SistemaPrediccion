<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Ejercicio;

class EjercicioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dificultad', ChoiceType::class,
                array(
                    'label'=>'Dificultad',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control select2'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => Ejercicio::DIFICULTADES,
                    'required' => true,
                )
            )
            ->add('estado', ChoiceType::class,
                array(
                    'label'=>'Estado',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control select2'),
                    'empty_value' => 'Activo para usar en practicas',
                    'choices'  => Ejercicio::ESTADOS,
                )
            )
            ->add('tema', EntityType::class, 
                array(
                    'class' => 'AppBundle:Tema',
                    'choice_label' => 'nombre',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control select2'),
                    'required' => true,
                )
            )
            ->add('respuestas', CollectionType::class,
                array(
                    'label' => 'Respuestas (seleccion la correcta)',
                    'entry_type' => new RespuestaType(),
                    'required' => true,
                    'label_attr' => array('class' => 'control-label'),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'cascade_validation' => true,
                    )
            )
            ->add('enunciado', TextareaType::class,
                array(
                    'required' => true,
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control', 'ck-editor' => ''),
                    )
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ejercicio',
            //'cascade_validation' => true
        ));
    }
}
