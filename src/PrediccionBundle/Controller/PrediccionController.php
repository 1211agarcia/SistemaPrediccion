<?php

namespace PrediccionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Estudiante;

class PrediccionController extends Controller
{

/*
    $objData = serialize( $obj);
$filePath = getcwd().DIRECTORY_SEPARATOR."note".DIRECTORY_SEPARATOR."notice.txt";
if (is_writable($filePath)) {
    $fp = fopen($filePath, "w"); 
    fwrite($fp, $objData); 
    fclose($fp);
}*/
    /**
     * Finds and displays a Estudiante entity.
     *
     * @Route("prediccion/{id}", name="estudiante_prediccion")
     */
    public function prediccionAction(Estudiante $estudiante)
    {
        echo getcwd() . "\n";
        dump(chdir('../src/AppBundle/R'));
        dump($estudiante);
        $objData = serialize( $estudiante);
        dump($objData);
        $filePath = getcwd().DIRECTORY_SEPARATOR."estudiante.in";
        //if (is_writable($filePath)) {
            $fp = fopen($filePath, "w") or die("Can't create file");
            fwrite($fp, $estudiante->prediction_format_file());
            fclose($fp);
        //}

        return $this->render('estudiante/show.html.twig', array(
            'estudiante' => $estudiante,
            'CONST'=> array('CARRERAS' => Estudiante::CARRERAS,'NIVELES_EDUCATIVOS'=> Estudiante::NIVELES_EDUCATIVOS,'GESTIONES_PLANTEL' => Estudiante::GESTIONES_PLANTEL,'TIPOS_PLANTEL' => Estudiante::TIPOS_PLANTEL,'NIVELES_SOCIOECONOMICOS'=> Estudiante::NIVELES_SOCIOECONOMICOS)));
    }
    /**
     * @Route("prediccion/{n}")
     */
    public function indexAction($n = 5)
    {
        //https://stat.ethz.ch/R-manual/R-devel/library/base/html/scan.html
echo getcwd() . "\n";
dump(chdir('../src/AppBundle/R'));
            file_put_contents("data.txt", shell_exec("Rscript my_rscript.R"));

        echo "inicio...";
        echo "<pre>";
        echo (shell_exec("Rscript my_rscript2.R"));
        echo "</pre>";
        // current directory

// current directory
//echo getcwd() . "\n";
        
        //exec("php p.php");
        echo "fin...";
 
		  // return image tag
		  $nocache = rand();
		return new Response(
            "<html><body><img src='temp.png?$nocache' /></body></html>"
        );

    }
}
