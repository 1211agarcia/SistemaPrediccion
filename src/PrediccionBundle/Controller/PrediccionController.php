<?php

namespace PrediccionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("prediccion2/{id}", name="estudiante_prediccion")
     * @Method("POST")
     */
    public function prediccionAction(Estudiante $estudiante)
    {
        $objData = serialize( $estudiante);
        $filePath = getcwd().DIRECTORY_SEPARATOR."note".DIRECTORY_SEPARATOR."notice.txt";
        if (is_writable($filePath)) {
            $fp = fopen($filePath, "w"); 
            fwrite($fp, $objData); 
            fclose($fp);
        }

        return $this->render('estudiante/show.html.twig', array(
            'estudiante' => $estudiante,
        ));
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
