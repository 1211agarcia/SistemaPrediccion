<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Estudiante;
use AppBundle\Entity\Curso;

class HomeController extends Controller
{
    /**
     * @Route(name="homepage")
     */
    public function indexAction(Request $request)
    {

        if(!$this->getUser())
        {
            return $this->redirectToRoute('fos_user_security_login');
        }
        if($this->isGranted('ROLE_ESTUDIANTE'))
        {
            $em = $this->getDoctrine()->getManager();
            //Verificar cuantas practicas ha realizado
            $estudiante = new Estudiante();
            //Se obtiene el Estudiante
            $estudiante = $em->getRepository('UserBundle:Estudiante')->findBy(array('usuario' => $this->getUser()))[0];
            $estudiantes = array_slice($em->getRepository('UserBundle:Estudiante')->findAll(),0,5);
            // Se encuentran las practicas de este estudiante
            $practicas = $em->getRepository('AppBundle:Practica')->findBy(array('estudiante' => $estudiante));
            //Temas Actuales
            $temas = $em->getRepository('AppBundle:Tema')->findAll();
            $curso = new Curso();
            $curso->setTema($temas[0]);
            $estudiante->addCurso($curso);
            //Progreso

            
            //$this->forward('app.jarvis:predictionAction', array('estudiante' => $estudiante));




            $cursos = $estudiante->getCursos();
            //
            /*dump($temas);
            dump($curso);
            dump($estudiante);
            dump($cursos);*/

            return $this->render('home/estudiante.html.twig', array(
                'estudiante' => $estudiante,
                'estudiantes' => $estudiantes,
                'temas' => $temas,
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ));
        }
        // Si es profesor
        if($this->isGranted('ROLE_PROFESOR'))
        {
            $em = $this->getDoctrine()->getManager();
            // Se encuentran las practicas generadas
            $practicas = $em->getRepository('AppBundle:Practica')->findAll();
            $practicas_titulo = "Practicas Generadas";
            // se encuentran los estuduante registrados
            $estudiante = $em->getRepository('UserBundle:Estudiante')->findAll();
            // se encuentran los temas creados
            $temas = $em->getRepository('AppBundle:Tema')->findAll();
            
            $ejercicios = $em->getRepository('AppBundle:Ejercicio')->findAll();
            $contenido = array(
                'ejercicios' => count($ejercicios),
                'estudiantes' => count($estudiante),
                'estudiantes_titulo' => "Estudiantes registrados",
                'practicas' => count($practicas),
                'practicas_titulo' => "Practicas Generadas",
                'temas' => count($temas),
                'temas_titulo' => "Temas disponibles",
                );

        }
        if($this->isGranted('ROLE_VERIFICADOR'))
        {
            return $this->redirectToRoute('estudiante_index');   
        }
        if($this->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('users');   
        }
        return $this->render('home/index.html.twig', array(
            'contenido' => $contenido,
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
