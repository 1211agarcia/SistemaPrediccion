<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TemaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('padres', EntityType::class, 
                array(
                    'class' => 'AppBundle:Tema',
                    'choice_label' => 'nombre',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control select2',  'multiple'=>'multiple', 'data-placeholder'=>'Select un tema', 'style'=>"width: 100%" ),
                    'required' => false,
                    'multiple' => true,
                    'label'=>'Temas Antecesores',
                )
            )
            ->add('nombre', TextType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'required' => true,
                )
            )
            ->add('descripcion', TextareaType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control', 'ck-editor' => ''),
                    'required' => true,
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
            'data_class' => 'AppBundle\Entity\Tema'
        ));
    }
}
