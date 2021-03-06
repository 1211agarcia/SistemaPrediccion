<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RespuestaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('correcta')
            ->add('expresion', TextareaType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control', 'ck-editor' => ''),
                    'required' => true,
                    )
            )
            ->add('tema', EntityType::class, 
                array(
                    'class' => 'AppBundle:Tema',
                    'choice_label' => 'nombre',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control select2', 'data-placeholder'=>'Seleccione un tema'),
                    'required' => false,
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
            'data_class' => 'AppBundle\Entity\Respuesta',
            'cascade_validation' => true
        ));
    }
}
