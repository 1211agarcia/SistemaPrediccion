<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Practica;
use AppBundle\Entity\Ejercicio;
use AppBundle\Form\PracticaType;
use Doctrine\Common\Collections\ArrayCollection;
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
     * Generate a new Practica entity.
     *
     * @Route("/generate", name="practica_generate")
     * @Method({"GET", "POST"})
     */
    public function generateAction($tema=null, $dificultad_min=0)
    {
        $em = $this->getDoctrine()->getManager();
        $limit = 4; //es el limite de ejrcicios que tendra la practica
        $practica = new Practica();
        $temas = $em->getRepository('AppBundle:Tema')->findAll();
        $tema = $temas[0];
        $ejercicios = $em->getRepository('AppBundle:Ejercicio')->search($tema, true,0,5);
        //dump($em->getRepository('AppBundle:Ejercicio')->findAll()[0]->getRespuestas());
        if (count($ejercicios) < 5 ) {
            $limit = count($ejercicios);
        }
        $claves_aleatorias = array_rand($ejercicios, $limit);
        //dump($claves_aleatorias);
        //dump($ejercicios);

        $data = array();
        //dump($data);
        foreach ($claves_aleatorias as $key => $clave) {
            $ejercicio_aux = new Ejercicio();
            // Ejercicio seleccionado aleatoriamente
            $ejercicio_aux = clone $ejercicios[$clave];
            /*$ejercicio_aux->setEnunciado($ejercicios[$clave]->getEnunciado());
            $ejercicio_aux->setDificultad($ejercicios[$clave]->getDificultad());
            $ejercicio_aux->setTema($ejercicios[$clave]->getTema());
            $ejercicio_aux->setEstado($ejercicios[$clave]->getEstado());*/
            dump($ejercicios[$clave]);
            dump($ejercicio_aux);
            //Se buscan sus respuestas incorrectas
            $resp_incorrectas = $ejercicios[$clave]->getIncorrectas();
            dump($resp_incorrectas);
            //Se obtienen 3 de las respuestas incorrectas
            $incorre_rand = array_rand($resp_incorrectas, 3);
            //Se obtiene la respuesta correcta
            $resp_correcta = $ejercicios[$clave]->getCorrecta();
            dump($resp_correcta);
            // El arreglo ue contendras las opciones finales
            $opciones = array();
            foreach ($incorre_rand as $value) {
                $opciones[] = $resp_incorrectas[$value];
            }
            // Se añade la respuesta correcta entre las opciones
            $opciones[] = $resp_correcta;
            //se mezclan las opciones finales
            shuffle($opciones);
            $ejercicio_aux->setRespuestas($opciones);

            $data[] = array('ejercicio' => $ejercicio_aux, 
                            'respuesta' => null,
                            'correcta' => null);
        }
        dump($data);
        $out = array_values($data);
        json_encode($out);
        dump($out);
        $practica->setData($out);
        dump($practica);
            $em = $this->getDoctrine()->getManager();
            $em->persist($practica);
            $em->flush();

        $form = $this->createForm('AppBundle\Form\PracticaType', $practica);
        return $this->render('practica/show.html.twig', array(
            'practica' => $practica,
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
