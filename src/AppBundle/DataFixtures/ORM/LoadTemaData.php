<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ejercicio;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Tema;


class LoadTemaData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {


        $categoria = new Categoria();
        $categoria->setProcedimiento('<p><strong>1.</strong>&nbsp;&nbsp;Se lleva la ecuaci&oacute;n a la forma</p><p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/693f7b170.gif" style="height:23px; width:123px" /></p><p><strong>2.</strong>&nbsp;&nbsp;Se identifican los coeficientes&nbsp;<em>a</em>,&nbsp;<em>b</em>&nbsp;y&nbsp;<em>c</em>, con su respectivo signo</p><p><strong>3.</strong>&nbsp;&nbsp;Se hallan las ra&iacute;ces de la ecuaci&oacute;n aplicando la f&oacute;rmula cuadr&aacute;tica general</p><p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/694097350.gif" style="height:53px; width:151px" /></p>');
        $categoria->setNombre("Resolución de ecuaciones completas de segundo grado sin denominadores aplicando la fórmula general");
        
        $tema1 = new Tema();
        $tema1->setNombre("Ecuaciones de segundo grado");
        $tema1->removeAllCategorias();
        $tema1->addCategoria($categoria);

        $manager->persist($tema1);
        
        $categoria = new Categoria();
        $categoria->setProcedimiento('<p><strong>1.</strong>&nbsp;&nbsp;Se lleva la ecuaci&oacute;n a la forma</p><p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/693f7b170.gif" style="height:23px; width:123px" /></p><p><strong>2.</strong>&nbsp;&nbsp;Se identifican los coeficientes&nbsp;<em>a</em>,&nbsp;<em>b</em>&nbsp;y&nbsp;<em>c</em>, con su respectivo signo</p><p><strong>3.</strong>&nbsp;&nbsp;Se hallan las ra&iacute;ces de la ecuaci&oacute;n aplicando la f&oacute;rmula cuadr&aacute;tica general</p><p><img alt="MathType 6.0 Equation" src="http://www.algebra.jcbmat.com/694097350.gif" style="height:53px; width:151px" /></p>');
        $categoria->setNombre("Resolución de ecuaciones completas de segundo grado sin denominadores aplicando la fórmula general");
        
        $tema = new Tema();
        $tema->setNombre("Potencia");
        $tema->removeAllCategorias();
        $tema->addCategoria($categoria);
        $tema->addPadre($tema1);

        $manager->persist($tema);
        $manager->flush();
        
    }
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 2;
    }
}