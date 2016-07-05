<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Practica;
use AppBundle\Entity\Ejercicio;
use UserBundle\Entity\Estudiante;
use AppBundle\Form\PracticaType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        if ($this->isGranted('ROLE_ESTUDIANTE')) {
            $estudiante = new Estudiante();
            //Se obtiene el Estudiante
            $estudiante = $em->getRepository('UserBundle:Estudiante')->findBy(array('usuario' => $this->getUser()))[0];
            
            $practicas = $em->getRepository('AppBundle:Practica')->findBy(array('estudiante' => $estudiante));
        }
        else{
            $practicas = $em->getRepository('AppBundle:Practica')->findAll();
        }
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
        //dump($ejercicios);
        //dump($em->getRepository('AppBundle:Ejercicio')->findAll()[0]->getRespuestas());
        if (count($ejercicios) < $limit ) {
            //throw new Exception('No hay suficiente ejercicios disponibles para una practica de '.$limit.'.');
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
            //dump($ejercicios[$clave]);
            //dump($ejercicio_aux);
            //Se buscan sus respuestas incorrectas
            $resp_incorrectas = $ejercicios[$clave]->getIncorrectas();
            //dump($resp_incorrectas);
            //Se obtienen 3 de las respuestas incorrectas
            $incorre_rand = array_rand($resp_incorrectas, 3);
            //Se obtiene la respuesta correcta
            $resp_correcta = $ejercicios[$clave]->getCorrecta();
            //dump($resp_correcta);
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
                            'seleccion' => null);
        }
        //dump($data);
        //$out = array_values($data);
        //dump(json_encode($out));die;
        //dump($out);
        $practica->setData($data);
        $estudiante = new Estudiante();
        $estudiante = $em->getRepository('UserBundle:Estudiante')->findBy(array('usuario' => $this->getUser()))[0];
        $practica->setEstudiante($estudiante);
        dump($practica);
            $em->persist($practica);
            $em->flush();
        dump($practica);
        dump($em->getRepository('AppBundle:Practica')->findAll());

        $form = $this->createForm('AppBundle\Form\PracticaType', $practica);

        return $this->redirectToRoute('practica_start', array('id' => $practica->getId()));

    }

    /**
     * Finds and displays a Practica entity.
     *
     * @Route("/{id}", name="practica_show")
     * @Method("GET")
     */
    public function showAction(Practica $practica)
    {
        return $this->render('practica/show.html.twig', array(
            'practica' => $practica,

        ));
    }

    /**
     * Start a Practica entity.
     *
     * @Route("/{id}/start", name="practica_start")
     * @Method({"GET", "POST"})
     */
    public function startAction(Request $request, Practica $practica)
    {
        $form = $this->createForm('AppBundle\Form\PracticaType', $practica,
            array('action' => $this->generateUrl('practica_start', array('id' => $practica->getId()))));
        $form->add('submit', 'submit');
        $form->handleRequest($request);

        $i=0;
        if ($form->isSubmitted() && $form->isValid()) {
            // Mientras no se encuentre el siguiente ejercicio a resolver
            $encontrado = false;
            while(!$encontrado && $i < count($practica->getData()) ) {
                $encontrado = ($practica->getData()[$i]['seleccion'] == null);
                $i++;
            }
            $em = $this->getDoctrine()->getManager();
            $data = array();
            $data = $practica->getData();
            $data[$i-1]['seleccion'] = $form['seleccion']->getData();
            $practica->setData($data);
            if (count($practica->getData()) == $i) {
                $practica->setFin(new \DateTime());
            }
            $em->flush();
            dump($practica);
            //Si finalizo tonces show practica
        }
        if ($practica->getFinalizada()) {
            return $this->redirectToRoute('practica_show', array('id' => $practica->getId()));
        }
        return $this->render('practica/start.html.twig', array(
            'practica' => $practica,
            'actual' => $i,
            'form' => $form->createView(),
        ));
    }
}
