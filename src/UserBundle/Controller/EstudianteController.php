<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Estudiante;
use UserBundle\Form\EstudianteType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
/**
 * Estudiante controller.
 *
 * @Route("/estudiante")
 */
class EstudianteController extends Controller
{
    /**
     * Lists all Estudiante entities.
     *
     * @Route("/", name="estudiante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $estudiantes = $em->getRepository('UserBundle:Estudiante')->findAll();

        return $this->render('estudiante/index.html.twig', array(
            'estudiantes' => $estudiantes,
        ));
    }

    /**
     * Creates a new Estudiante entity.
     *
     * @Route("/new", name="estudiante_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $estudiante = new Estudiante();
        $form = $this->createForm('UserBundle\Form\EstudianteType', $estudiante,
            array('action' => $this->generateUrl('estudiante_new')));
        $form->add('submit', 'submit');
        $form->handleRequest($request);

        //dump($estudiante);
        if ($form->isSubmitted() && $form->isValid()) {
            /* SE AGREGAN DATOS POR DEFECTO DE USUARIO DE ESTUDIANTE*/
            $estudiante->getUsuario()->setEnabled(true);
            $estudiante->getUsuario()->addRole(1);
            $estudiante->getUsuario()->setPlainPassword("V".$estudiante->getCedula());
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();
            /*** Inicialización de Estudiante ***/
            
            return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Estudiante entity.
     *
     * @Route("/{id}", name="estudiante_show")
     * @Method("GET")
     */
    public function showAction(Estudiante $estudiante)
    {
        $deleteForm = $this->createDeleteForm($estudiante);

        return $this->render('estudiante/show.html.twig', array(
            'estudiante' => $estudiante,
        ));
    }

    /**
     * Displays a form to edit an existing Estudiante entity.
     *
     * @Route("/{id}/edit", name="estudiante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Estudiante $estudiante)
    {
        $editForm = $this->createForm('UserBundle\Form\EstudianteType', $estudiante,
            array('action' => $this->generateUrl('estudiante_edit', array('id' => $estudiante->getId()))));
        $editForm
            ->add('prediccion', Checkboxtype::class,
                array('attr' => array('ng-model'=>'checked'),
                    'required'=> false,
                'mapped' => false))
            ->add('submit', 'submit');
        dump($editForm['prediccion']->getData());
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();

            return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $editForm->createView(),
            'edition'=>$estudiante->getId()
        ));
    }

    /**
     * Deletes a Estudiante entity.
     *
     * @Route("/{id}", name="estudiante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Estudiante $estudiante)
    {
        $form = $this->createDeleteForm($estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estudiante);
            $em->flush();
        }

        return $this->redirectToRoute('estudiante_index');
    }

    /**
     * Creates a form to delete a Estudiante entity.
     *
     * @param Estudiante $estudiante The Estudiante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Estudiante $estudiante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiante_delete', array('id' => $estudiante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
