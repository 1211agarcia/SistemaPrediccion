<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Estudiante as estudiante;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EstudianteVerifyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estado', ChoiceType::class,
                array(
                    'label'=> false,
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => estudiante::ESTADOS,
                    'required' => true,
                )
            )
            //->add('mensaje', 'texarea', array('property_path' => false));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Estudiante',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'estudiante_verification';
    }
}
