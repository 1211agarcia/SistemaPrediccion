<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ExpresionMatematica;
use AppBundle\Form\ExpresionMatematicaType;

/**
 * ExpresionMatematica controller.
 *
 * @Route("/expresionmatematica")
 */
class ExpresionMatematicaController extends Controller
{
    /**
     * Lists all ExpresionMatematica entities.
     *
     * @Route("/", name="expresionmatematica_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expresionMatematicas = $em->getRepository('AppBundle:ExpresionMatematica')->findAll();

        return $this->render('expresionmatematica/index.html.twig', array(
            'expresionMatematicas' => $expresionMatematicas,
        ));
    }

    /**
     * Creates a new ExpresionMatematica entity.
     *
     * @Route("/new", name="expresionmatematica_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expresionMatematica = new ExpresionMatematica();
        $form = $this->createForm('AppBundle\Form\ExpresionMatematicaType', $expresionMatematica,
            array('action' => $this->generateUrl('expresionmatematica_new')));
        $form->add('submit', 'submit');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expresionMatematica);
            $em->flush();

            return $this->redirectToRoute('expresionmatematica_show', array('id' => $expresionMatematica->getId()));
        }

        return $this->render('expresionmatematica/new.html.twig', array(
            'expresionMatematica' => $expresionMatematica,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ExpresionMatematica entity.
     *
     * @Route("/{id}", name="expresionmatematica_show")
     * @Method("GET")
     */
    public function showAction(ExpresionMatematica $expresionMatematica)
    {
        $deleteForm = $this->createDeleteForm($expresionMatematica);

        return $this->render('expresionmatematica/show.html.twig', array(
            'expresionMatematica' => $expresionMatematica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ExpresionMatematica entity.
     *
     * @Route("/{id}/edit", name="expresionmatematica_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ExpresionMatematica $expresionMatematica)
    {
        $editForm = $this->createForm('AppBundle\Form\ExpresionMatematicaType', $expresionMatematica,
            array('action' => $this->generateUrl('expresionmatematica_edit', array('id'=>$expresionMatematica->getId()))));
        $editForm->add('submit', 'submit');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expresionMatematica);
            $em->flush();

            return $this->redirectToRoute('expresionmatematica_edit', array('id' => $expresionMatematica->getId()));
        }

        return $this->render('expresionmatematica/new.html.twig', array(
            'expresionMatematica' => $expresionMatematica,
            'form' => $editForm->createView(),
            'edition' => $expresionMatematica->getId(),
        ));
    }

    /**
     * Deletes a ExpresionMatematica entity.
     *
     * @Route("/{id}", name="expresionmatematica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ExpresionMatematica $expresionMatematica)
    {
        $form = $this->createDeleteForm($expresionMatematica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expresionMatematica);
            $em->flush();
        }

        return $this->redirectToRoute('expresionmatematica_index');
    }

    /**
     * Creates a form to delete a ExpresionMatematica entity.
     *
     * @param ExpresionMatematica $expresionMatematica The ExpresionMatematica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ExpresionMatematica $expresionMatematica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expresionmatematica_delete', array('id' => $expresionMatematica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
