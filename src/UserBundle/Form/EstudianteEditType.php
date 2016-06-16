<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Form\Type\RegistrationType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EstudianteEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', RegistrationType::class)
            ->add('nombre', TextType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'required' => true,
                )
            )
            ->add('apellido', TextType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'required' => true,
                )
            )
            ->add('cedula', IntegerType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'min' => 1
                    ),
                    'required' => true,
                )
            )
            ->add('genero', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'choices' => array('1' => 'Masculino', '0' => 'Femenino'),
                    'required' => true,
                )
            );
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
        return 'estudiante_edit';
    }
}
