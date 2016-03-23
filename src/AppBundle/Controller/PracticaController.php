<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Practica;
use AppBundle\Form\PracticaType;

/**
 * Practica controller.
 *
 * @Route("/practica")
 */
class PracticaController extends Controller
{
    /**
     * Lists all Practica entities.
     *
     * @Route("/", name="practica_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $practicas = $em->getRepository('AppBundle:Practica')->findAll();

        return $this->render('practica/index.html.twig', array(
            'practicas' => $practicas,
        ));
    }

    /**
     * Creates a new Practica entity.
     *
     * @Route("/new", name="practica_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $practica = new Practica();
        $form = $this->createForm('AppBundle\Form\PracticaType', $practica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($practica);
            $em->flush();

            return $this->redirectToRoute('practica_show', array('id' => $practica->getId()));
        }

        return $this->render('practica/new.html.twig', array(
            'practica' => $practica,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Practica entity.
     *
     * @Route("/{id}", name="practica_show")
     * @Method("GET")
     */
    public function showAction(Practica $practica)
    {
        $deleteForm = $this->createDeleteForm($practica);

        return $this->render('practica/show.html.twig', array(
            'practica' => $practica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Practica entity.
     *
     * @Route("/{id}/edit", name="practica_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Practica $practica)
    {
        $deleteForm = $this->createDeleteForm($practica);
        $editForm = $this->createForm('AppBundle\Form\PracticaType', $practica);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($practica);
            $em->flush();

            return $this->redirectToRoute('practica_edit', array('id' => $practica->getId()));
        }

        return $this->render('practica/edit.html.twig', array(
            'practica' => $practica,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Practica entity.
     *
     * @Route("/{id}", name="practica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Practica $practica)
    {
        $form = $this->createDeleteForm($practica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($practica);
            $em->flush();
        }

        return $this->redirectToRoute('practica_index');
    }

    /**
     * Creates a form to delete a Practica entity.
     *
     * @param Practica $practica The Practica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Practica $practica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('practica_delete', array('id' => $practica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
