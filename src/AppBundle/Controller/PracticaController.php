<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
    public function generateAction()
    {
        if($this->isGranted('ROLE_ESTUDIANTE'))
        {
            //SI aca se debe preguntar si el estudiante tiene una practica comenzada
            //Entonces se 
            //
            $em = $this->getDoctrine()->getManager();
            $limit = 4; //es el limite de ejrcicios que tendra la practica
            $dificultad_min = 0;
            $dificultad_max = 5;
            $tema=null;
            $practica = new Practica();
            $temas = $em->getRepository('AppBundle:Tema')->findAll();
            $tema = $temas[0];
            $ejercicios = $em->getRepository('AppBundle:Ejercicio')->search($tema,$dificultad_min,$dificultad_max);
            if (count($ejercicios) < $limit ) {
                throw new Exception('No hay suficiente ejercicios disponibles para una practica de '.$limit.'.');
                $limit = count($ejercicios);
            }
            $claves_aleatorias = array_rand($ejercicios, $limit);

            $data = array();
            //dump($data);
            foreach ($claves_aleatorias as $key => $clave) {
                $ejercicio_aux = new Ejercicio();
                // Ejercicio seleccionado aleatoriamente
                $ejercicio_aux = clone $ejercicios[$clave];
                //Se buscan sus respuestas incorrectas
                $resp_incorrectas = $ejercicios[$clave]->getIncorrectas();
                //Se obtienen 3 de las respuestas incorrectas
                $incorre_rand = array_rand($resp_incorrectas, 3);
                //Se obtiene la respuesta correcta
                $resp_correcta = $ejercicios[$clave]->getCorrecta();
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
            $practica->setData($data);
            $estudiante = new Estudiante();
            $estudiante = $em->getRepository('UserBundle:Estudiante')->findBy(array('usuario' => $this->getUser()))[0];
            $practica->setEstudiante($estudiante);
            //Se guarda la practica
            $em->persist($practica);
            $em->flush();

            return $this->redirectToRoute('practica_start', array('id' => $practica->getId()));
        }
        return $this->redirectToRoute('home');
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
        /*$form = $this->createForm('AppBundle\Form\PracticaType', $practica,
            array('action' => $this->generateUrl('practica_start', array('id' => $practica->getId()))));
        $form->add('submit', 'submit');
        $form->handleRequest($request);

        $i=0;
        if ($form->isSubmitted() && $form->isValid() && !$practica->getFinalizada()) {
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
        }
        if ($practica->getFinalizada()) {
            return $this->redirectToRoute('practica_show', array('id' => $practica->getId()));
        }*/
                $response = array();
                $response['id'] = 0;
                $response['id_practica'] = $practica->getId();
                $response['enunciado'] = htmlentities ($practica->getData()[0]['ejercicio']->getEnunciado());
                $response['enunciado'] = htmlentities ($response['enunciado']);
                $response['respuestas'] = array(
                    htmlentities ($practica->getData()[0]['ejercicio']->getRespuestas()[0]->getExpresion()),
                    htmlentities ($practica->getData()[0]['ejercicio']->getRespuestas()[1]->getExpresion()),
                    htmlentities ($practica->getData()[0]['ejercicio']->getRespuestas()[2]->getExpresion()),
                    htmlentities ($practica->getData()[0]['ejercicio']->getRespuestas()[3]->getExpresion())
                );
                dump(($response));
                dump(json_encode($response));
                dump(json_encode($practica->getData()[0]['ejercicio']->getEnunciado()));
                
                
        return $this->render('practica/start.html.twig', array(
            'practica' => $practica,
            'actual' => 0,
            'practica_json' =>  json_encode($response)
        ));
    }


    /**
     * Evaluar a Practica entity.
     *
     * @Route("/_evaluar", name="practica_evaluar",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function evaluarAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            
            
            $evaluacion = json_decode($request->getContent(),true);
            
            $practica = $em->getRepository('AppBundle:Practica')->find($evaluacion['practica_id']);

            if ($evaluacion['seleccion'] >= 0 && $evaluacion['seleccion'] < 5) {
                
            }
            while(!$encontrado && $i < count($practica->getData()) ) {
                $encontrado = ($practica->getData()[$i]['seleccion'] == null);
                $i++;
            }
            $data = array();
            $data = $practica->getData();
            $data[$i-1]['seleccion'] = $form['seleccion']->getData();
            $practica->setData($data);
            if (count($practica->getData()) == $i) {
                $practica->setFin(new \DateTime());
            }
            $em->flush();

        }
                $datos = new JsonResponse($response, 200);
            return $datos;
        
    }
}
