<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ejercicio;
use AppBundle\Form\EjercicioType;

/**
 * Ejercicio controller.
 *
 * @Route("/ejercicio")
 */
class EjercicioController extends Controller
{
    /**
     * Lists all Ejercicio entities.
     *
     * @Route("/", name="ejercicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ejercicios = $em->getRepository('AppBundle:Ejercicio')->findAll();

        return $this->render('ejercicio/index.html.twig', array(
            'ejercicios' => $ejercicios,
        ));
    }

    /**
     * Creates a new Ejercicio entity.
     *
     * @Route("/new", name="ejercicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ejercicio = new Ejercicio();
        $form = $this->createForm('AppBundle\Form\EjercicioType', $ejercicio,
            array('action' => $this->generateUrl('ejercicio_new')));
        $form->add('submit', 'submit');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ejercicio);
            $em->flush();

            return $this->redirectToRoute('ejercicio_show', array('id' => $ejercicio->getId()));
        }

        return $this->render('ejercicio/new.html.twig', array(
            'ejercicio' => $ejercicio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ejercicio entity.
     *
     * @Route("/{id}", name="ejercicio_show")
     * @Method("GET")
     */
    public function showAction(Ejercicio $ejercicio)
    {
        $deleteForm = $this->createDeleteForm($ejercicio);

        return $this->render('ejercicio/show.html.twig', array(
            'ejercicio' => $ejercicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ejercicio entity.
     *
     * @Route("/{id}/edit", name="ejercicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ejercicio $ejercicio)
    {
        $editForm = $this->createForm('AppBundle\Form\EjercicioType', $ejercicio,
            array('action' => $this->generateUrl('ejercicio_edit', array('id' => $ejercicio->getId()))));
        $editForm->add('submit', 'submit');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ejercicio);
            $em->flush();

            return $this->redirectToRoute('ejercicio_show', array('id' => $ejercicio->getId()));
        }

        return $this->render('ejercicio/new.html.twig', array(
            'ejercicio' => $ejercicio,
            'form' => $editForm->createView(),
            'edition'=>$ejercicio->getId()
        ));
    }

    /**
     * Deletes a Ejercicio entity.
     *
     * @Route("/{id}", name="ejercicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ejercicio $ejercicio)
    {
        $form = $this->createDeleteForm($ejercicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ejercicio);
            $em->flush();
        }

        return $this->redirectToRoute('ejercicio_index');
    }

    /**
     * Creates a form to delete a Ejercicio entity.
     *
     * @param Ejercicio $ejercicio The Ejercicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ejercicio $ejercicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ejercicio_delete', array('id' => $ejercicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
