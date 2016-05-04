<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
                    'attr'=> array('class' => 'form-control'),
                    'choices' => array(
                        1=>'1 - Facil',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10 - Dificil')
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
            ->add('soluciones', CollectionType::class,
                array(
                    'entry_type' => new ExpresionMatematicaType(),
                    'required' => true,
                    'label_attr' => array('class' => 'control-label'),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    )
            )
            ->add('solucionDetallada', TextareaType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control', 'ck-editor' => ''),
                    'required' => true,
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
