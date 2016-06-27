<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ejercicio;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Tema;
use AppBundle\Entity\Respuesta;

class LoadEjercicioData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $tema = $manager->getRepository('AppBundle:Tema')->findBy(array('nombre' => 'Ecuaciones de segundo grado'))[0];
        for ($i=1; $i <= 10; $i++) { 
            $respuesta = new Respuesta();
            $respuesta->setExpresion('<p><span class="math-tex">\(x_{1} = 1, x_{2} = \frac{2}{3}\)</span></p>');
            $respuesta->setTema($tema);
            $respuesta->setCorrecta(true);

            $ejercicio = new Ejercicio();

            $ejercicio->setDificultad(rand(0,4));
            $ejercicio->setEstado(rand(0,1));
            $ejercicio->setTema($tema);

            $ejercicio->setEnunciado('<p> ejercicio '.$i.'<img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/694191170.gif" style="height:23px; width:145px" /></p>');
            $ejercicio->removeAllRespuestas();
            $ejercicio->addRespuesta($respuesta);
            for ($ii=0; $ii < 10; $ii++) { 
                $respuesta = new Respuesta();
                $respuesta->setExpresion('<p>respuesta incorrecta</p>');
                $respuesta->setTema($tema);
                $respuesta->setCorrecta(false);
                $ejercicio->addRespuesta($respuesta);
            }
            $manager->persist($ejercicio);
        }
        $manager->flush();
        
    }
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 5;
    }
}