<?php

namespace PrediccionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PrediccionController extends Controller
{
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
