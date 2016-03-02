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
        exec("Rscript my_rscript.R $n");
 
		  // return image tag
		  $nocache = rand();
		return new Response(
            "<html><body><img src='R/temp.png?$nocache' /></body></html>"
        );

    }
}
