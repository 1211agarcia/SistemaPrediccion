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
            /*************************
             * LOGICA DIFUSA         *
             *************************
             * AQUI VA LA CAJA NEGRA *
             * DE LOGICA DIFUSA LA   *
             * CUAL DEFINE LA        *
             * DIFICULTAD DEL        *
             * EJERCICIO             *
             ************************/

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
        if ($practica->getFinalizada()) {
            return $this->redirectToRoute('homepage');
        }
        $i=-1;
        // Mientras no se encuentre el siguiente ejercicio a resolver
        $encontrado = false;
        while(!$encontrado && $i < count($practica->getData()) ) {
            $i++;
            $encontrado = ($practica->getData()[$i]['seleccion'] == null);
        }
        $caracter_especial = array("\\","\"","\'");
        $caracter_auxiliar = array("__X__","&quot;","__S__");

        $response = array();
        $response['id'] = $i;
        $response['id_practica'] = $practica->getId();
        $response['enunciado'] = str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[0]['ejercicio']->getEnunciado()));
        $response['respuestas'] = array(
            str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[0]['ejercicio']->getRespuestas()[0]->getExpresion())),
            str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[0]['ejercicio']->getRespuestas()[1]->getExpresion())),
            str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[0]['ejercicio']->getRespuestas()[2]->getExpresion())),
            str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[0]['ejercicio']->getRespuestas()[3]->getExpresion()))
        );
  
        return $this->render('practica/start.html.twig', array(
            'practica' => $practica,
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
            $practica = $em->getRepository('AppBundle:Practica')->find($evaluacion['id_practica']);

            $data = array();
            $data = $practica->getData();
            $i = $evaluacion['id'];
            $data[$i]['seleccion'] = $evaluacion['seleccion'];
            $practica->setData($data);
            $response = array();
            $response['id'] = $i+1;
            $response['resultado'] = $practica->getData()[$i]['ejercicio']->getRespuestas()[$evaluacion['seleccion']]->getCorrecta()? 1 : 2;//retorna si la respuesta selecionada es correcta o no.
            $response['id_practica'] = $practica->getId();
            if (count($practica->getData()) > ( $i +1)) {//Si no es es el ultimo
                $caracter_especial = array("\\","\"","\'");
                $caracter_auxiliar = array("__X__","&quot;","__S__");
                $response['enunciado'] = str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[$i+1]['ejercicio']->getEnunciado()));                    $response['respuestas'] = array(
                    str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[$i+1]['ejercicio']->getRespuestas()[0]->getExpresion())),
                    str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[$i+1]['ejercicio']->getRespuestas()[1]->getExpresion())),
                    str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[$i+1]['ejercicio']->getRespuestas()[2]->getExpresion())),
                    str_replace($caracter_especial,$caracter_auxiliar, ($practica->getData()[$i+1]['ejercicio']->getRespuestas()[3]->getExpresion()))
                );
            }else
            {// Se cierra la practica
                $practica->setFin(new \DateTime());   
                /*************************
                 * LOGICA DIFUSA         *
                 *************************
                 * AQUI VA LA CAJA NEGRA *
                 * DE LOGICA DIFUSA LA   *
                 * CUAL ACTUALIZA EL     *
                 * NIVEL DE PERTENENCIA  *
                 * EN EL TEMA ACTUAL     *
                 ************************/
            }

            $em->flush();
            $datos = new JsonResponse($response, 200);
        }else
        {
            $datos = new JsonResponse($response, 500);
        }
        
        return $datos;
        
    }
}
