<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Solucion;

class LoadSolucionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $solucion = new Solucion();
        $solucion->setCategoria('Cat_1');
        $solucion->setTipo('simple');
        $solucion->setExpresion('x_{1} = 1, x_{2} = \frac{2}{3}');
        $solucion->setTema('Resolución de ecuaciones de segundo grado');
        $solucion->setNivel(1);
        $manager->persist($solucion);
        $manager->flush();
        for ($i=1; $i <= 50 ; $i++) { 
           
            $solucion = new Solucion();
            $solucion->setCategoria('Cat_'.$i);
            $solucion->setTipo('simple');
            $solucion->setExpresion('x_{1} = '.($i + 1).', x_{2} = \frac{2}{'.($i + 2).'}');
            $solucion->setTema('Resolución de ecuaciones de segundo grado');
            $solucion->setNivel(1);

            $manager->persist($solucion);
            $manager->flush();
        }
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