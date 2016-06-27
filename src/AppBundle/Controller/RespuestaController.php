<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Respuesta;
use AppBundle\Form\RespuestaType;

/**
 * Respuesta controller.
 *
 * @Route("/respuesta")
 */
class RespuestaController extends Controller
{
    /**
     * Lists all Respuesta entities.
     *
     * @Route("/", name="respuesta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $respuestas = $em->getRepository('AppBundle:Respuesta')->findAll();

        return $this->render('respuesta/index.html.twig', array(
            'respuestas' => $respuestas,
        ));
    }

    /**
     * Creates a new Respuesta entity.
     *
     * @Route("/new", name="respuestaca_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $respuesta = new Respuesta();
        $form = $this->createForm('AppBundle\Form\RespuestaType', $respuesta,
            array('action' => $this->generateUrl('respuesta_new')));
        $form->add('submit', 'submit');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            return $this->redirectToRoute('respuesta_show', array('id' => $respuesta->getId()));
        }

        return $this->render('respuesta/new.html.twig', array(
            'respuesta' => $respuesta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Respuesta entity.
     *
     * @Route("/{id}", name="respuestaa_show")
     * @Method("GET")
     */
    public function showAction(Respuesta $respuesta)
    {
        $deleteForm = $this->createDeleteForm($respuesta);

        return $this->render('respuesta/show.html.twig', array(
            'respuesta' => $respuesta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Respuesta entity.
     *
     * @Route("/{id}/edit", name="respuestaa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Respuesta $respuesta)
    {
        $editForm = $this->createForm('AppBundle\Form\RespuestaType', $respuesta,
            array('action' => $this->generateUrl('respuesta_edit', array('id'=>$respuesta->getId()))));
        $editForm->add('submit', 'submit');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            return $this->redirectToRoute('respuesta_edit', array('id' => $respuesta->getId()));
        }

        return $this->render('respuesta/new.html.twig', array(
            'respuesta' => $respuesta,
            'form' => $editForm->createView(),
            'edition' => $respuesta->getId(),
        ));
    }

    /**
     * Deletes a Respuesta entity.
     *
     * @Route("/{id}", name="respuestadelete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Respuesta $respuesta)
    {
        $form = $this->createDeleteForm($respuesta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($respuesta);
            $em->flush();
        }

        return $this->redirectToRoute('respuesta_index');
    }

    /**
     * Creates a form to delete a Respuesta entity.
     *
     * @param Respuesta $respuesta The Respuesta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Respuesta $respuesta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('respuesta_delete', array('id' => $respuesta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
