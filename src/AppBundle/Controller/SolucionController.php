<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Solucion;
use AppBundle\Form\SolucionType;

/**
 * Solucion controller.
 *
 * @Route("/solucion")
 */
class SolucionController extends Controller
{
    /**
     * Lists all Solucion entities.
     *
     * @Route("/", name="solucion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $solucions = $em->getRepository('AppBundle:Solucion')->findAll();

        return $this->render('solucion/index.html.twig', array(
            'solucions' => $solucions,
        ));
    }

    /**
     * Creates a new Solucion entity.
     *
     * @Route("/new", name="solucion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $solucion = new Solucion();
        $form = $this->createForm('AppBundle\Form\SolucionType', $solucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($solucion);
            $em->flush();

            return $this->redirectToRoute('solucion_show', array('id' => $solucion->getId()));
        }

        return $this->render('solucion/new.html.twig', array(
            'solucion' => $solucion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Solucion entity.
     *
     * @Route("/{id}", name="solucion_show")
     * @Method("GET")
     */
    public function showAction(Solucion $solucion)
    {
        $deleteForm = $this->createDeleteForm($solucion);

        return $this->render('solucion/show.html.twig', array(
            'solucion' => $solucion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Solucion entity.
     *
     * @Route("/{id}/edit", name="solucion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Solucion $solucion)
    {
        $deleteForm = $this->createDeleteForm($solucion);
        $editForm = $this->createForm('AppBundle\Form\SolucionType', $solucion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($solucion);
            $em->flush();

            return $this->redirectToRoute('solucion_edit', array('id' => $solucion->getId()));
        }

        return $this->render('solucion/edit.html.twig', array(
            'solucion' => $solucion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Solucion entity.
     *
     * @Route("/{id}", name="solucion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Solucion $solucion)
    {
        $form = $this->createDeleteForm($solucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($solucion);
            $em->flush();
        }

        return $this->redirectToRoute('solucion_index');
    }

    /**
     * Creates a form to delete a Solucion entity.
     *
     * @param Solucion $solucion The Solucion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Solucion $solucion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solucion_delete', array('id' => $solucion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
