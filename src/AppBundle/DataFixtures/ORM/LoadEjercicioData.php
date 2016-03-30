<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ejercicio;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Tema;
use AppBundle\Entity\ExpresionMatematica;

class LoadEjercicioData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $tema = $manager->getRepository('AppBundle:Tema')->findBy(array('nombre' => 'Ecuaciones de segundo grado'))[0];
        
        
        $expresion = new ExpresionMatematica();
        $expresion->setExpresion('<span class="math-tex">\(x_{1} = 1, x_{2} = \frac{2}{3}\)</span></p>');
        $expresion->setTema($tema);

        $ejercicio = new Ejercicio();

        $ejercicio->setDificultad(1);
        $ejercicio->setTema($tema);

        $ejercicio->setSolucionDetallada('<p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/6553af640.gif" style="height:356px; width:687px" /></p>');

        $ejercicio->setEnunciado('<p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/694191170.gif" style="height:23px; width:145px" /></p>');
        $ejercicio->removeAllSoluciones();
        $ejercicio->addSolucion($expresion);

        $manager->persist($ejercicio);
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