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
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'label'=>'Total materias cursadas',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array(
                        'class' => 'form-control',
                        'min' => 5
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
            ->add('primeraOpcion', ChoiceType::class,
                array(
                    'label'=>'1ra Opción del curso',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => estudiante::CARRERAS,
                    'required' => true,
                )
            )
            ->add('segundaOpcion', ChoiceType::class,
                array(
                    'label'=>'2da Opción del curso',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::CARRERAS,
                    'required' => true,
                )
            )
            ->add('genero', ChoiceType::class,
                array(
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'choices' => array('1' => 'Masculino', '0' => 'Femenino'),
                    'required' => false,
                )
            )
            ->add('esAsignadoOPSU', ChoiceType::class,
                array(
                    'label'=>'¿Asignado OPSU?',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices' => array('Sí' => '1', 'No' => '0'),
                    // always include this
                    'choices_as_values' => true,
                    'required' => false,
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
                    'label'=>'Mayor nivel de estudio de padres',
                    'label_attr' => array('class' => 'control-label'),
                    'attr'=> array('class' => 'form-control'),
                    'placeholder' => 'Seleccionar',
                    'choices'  => estudiante::NIVELES_EDUCATIVOS,
                    'required' => true,
                )
            )
            ->add('credencial', FileType::class,
                array(
                    'label' => false,
                    'required' => true,
                    'data_class' => null
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
