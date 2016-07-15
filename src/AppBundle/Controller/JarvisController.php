<?php
/********************
 * Controlador de solicitudes inteligentes e intereaccion con sistemas inteligentes
 * Controlador de Peticiones de Apoyo inteligente
 *
 *---------------------------------------
 * Actividades
 *-------------------------------------------
 * 1 - Prediccion del nivel de conocimiento 
 * 2 - Inicializar Progreso y calificacion
 * 3 - Sugerir proxima dificultad.
 * 4 - Actualiza Progreso
 *
 *
 *
 */
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
 * Jarvis controller.
 *
 */
class JarvisController extends Controller
{ 
	private $templating;

    public function __construct()
    {
        $this->templating = null;
    }

    public function predictionAction(Estudiante $estudiante)
    {
        echo getcwd() . "\n";
        dump(chdir('../src/AppBundle/R'));
        echo getcwd() . "\n";
        //file_put_contents("data.txt", shell_exec("Rscript inicio.R"));
        dump(json_encode($estudiante->prediction_format_file()));
        $vector = json_encode($estudiante->prediction_format_file());
        dump(shell_exec("Rscript prediccion.r $vector"));

        echo "inicio...";
        //echo "<pre>";
        //echo (shell_exec("Rscript my_rscript2.R"));
        //echo "</pre>";
        // current directory

        // current directory
        //echo getcwd() . "\n";
        
        //exec("php p.php");
        echo "fin...";die;
    }

	/**
     *
     * @Route("/", name="jarvis_prediction")
     * @Method("GET")
     */
    public function tata()
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

}

   