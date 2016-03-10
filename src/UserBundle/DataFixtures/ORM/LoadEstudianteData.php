<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Estudiante;

class LoadEstudianteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //$users = $manager->getRepository('UserBundle:Usuario')->findStudentsToCreate("ROLE_ESTUDIANTE");
        
        $users = $manager->getRepository('UserBundle:Usuario')->findAll();
        foreach ($users as $i=> $user) {
           
            $est = new Estudiante();
            $est->setNombre("nombre ".$i);
            $est->setApellido("apellido ".$i);
            $est->setCedula(20000 + $i);
            
            $est->setNotaPrimero(rand(100,200)/10);
            $est->setNotaSegundo(rand(100,200)/10);
            $est->setNotaTercero(rand(100,200)/10);
            $est->setNotaCuarto(rand(100,200)/10);
            $est->setCantMaterias(rand(40,60));
            $est->setPromedio(rand(100,200)/10);
            
            $est->setPrimeraOpcionOpsu(rand(0,4));
            $est->setSegundaOpcionOpsu(rand(0,4));
            $est->setSexo(rand(0,1));
            $est->setTieneAccesoInternet(rand(0,1));
            $est->setEsAsignadoOPSU(rand(0,1));
            $est->setGestionPlantel(rand(0,2));
            $est->setTipoPlantel(rand(0,1));
            $est->setNivelSocioeconomico(rand(0,2));
            $est->setNivelEstudioPadres(rand(0,3));
            $est->setUsuario($user);

            $manager->persist($est);
            $manager->flush();
        }
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