<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Estudiante as estudiante;
use UserBundle\Form\Type\RegistrationType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use UserBundle\Repository\UsuarioRepository as UserRepository;

class EstudianteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*  ->add('usuario', EntityType::class, 
                array(
                    'class' => 'UserBundle:Usuario',
                    'choice_label' => 'username',
                    'query_builder' => function (UserRepository $er) {
                        return $er->findStudentsToCreateQb('ROLE_ESTUDIANTE');
                    },
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'required' => true,
                )
            )*/
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
            ->add('notaPrimero', IntegerType::class,
                array(
                    'label'=>'1er',
                    'label_attr' => array('class' => 'control-label2'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => 1,
                        'max' => 20
                    ),
                    'required' => true,
                )
            )
            ->add('notaSegundo', IntegerType::class,
                array(
                    'label'=>'2do',
                    'label_attr' => array('class' => 'control-label2'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => 1,
                        'max' => 20
                    ),
                    'required' => true,
                )
            )
            ->add('notaTercero', IntegerType::class,
                array(
                    'label'=>'3er',
                    'label_attr' => array('class' => 'control-label2'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => 1,
                        'max' => 20
                    ),
                    'required' => true,
                )
            )
            ->add('notaCuarto', IntegerType::class,
                array(
                    'label'=>'4to',
                    'label_attr' => array('class' => 'control-label2'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => 1,
                        'max' => 20
                    ),
                    'required' => true,
                )
            )
            ->add('cantMaterias', IntegerType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'min' => 1
                    ),
                    'required' => true,
                )
            )
            ->add('promedio', IntegerType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'step' => '0.01',
                        'min' => 1,
                        'max' => 20
                    ),
                    'required' => true,
                )
            )
            ->add('primeraOpcionOpsu', ChoiceType::class,
                array(
                    'label'=>'1ra Opción',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => estudiante::CARRERAS,
                    'required' => true,
                )
            )
            ->add('segundaOpcionOpsu', ChoiceType::class,
                array(
                    'label'=>'2da Opción',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::CARRERAS,
                    'required' => true,
                )
            )
            ->add('sexo', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'choices' => array('0' => 'Masculino', '1' => 'Femenino'),
                    'required' => true,
                )
            )
            ->add('tieneAccesoInternet', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'placeholder',
                    'choices' => array('Sí' => true, 'No' => false),
                    'required' => true,
                )
            )
            ->add('esAsignadoOPSU', ChoiceType::class,
                array(
                    'label'=>'¿es Asignado?',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices' => array('Sí' => true, 'No' => false),
                    // always include this
                    'choices_as_values' => true,
                    'required' => true,
                )
            )
            ->add('gestionPlantel', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::GESTIONES_PLANTEL,
                    'required' => true,
                )
            )
            ->add('tipoPlantel', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::TIPOS_PLANTEL,
                    'required' => true,
                )
            )
            ->add('nivelSocioeconomico', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::NIVELES_SOCIOECONOMICOS,
                    'required' => true,
                )
            )
            ->add('nivelEstudioPadres', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::NIVELES_EDUCATIVOS,
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
            'data_class' => 'UserBundle\Entity\Estudiante',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'estudiante_registration';
    }
}
