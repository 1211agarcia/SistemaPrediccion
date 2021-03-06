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
            if ($i > 2 ) {
                $est = new Estudiante();
                $est->setCredencial('credencial_'.(20000 + $i).".pdf");
                             
                $est->setNombre("nombre ".$i);
                $est->setApellido("apellido ".$i);
                $est->setCedula(20000 + $i);
                
                $est->setNotaPrimero(rand(1000,2000)/100);
                $est->setNotaSegundo(rand(1000,2000)/100);
                $est->setNotaTercero(rand(1000,2000)/100);
                $est->setNotaCuarto(rand(1000,2000)/100);
                $est->setCantMaterias(rand(40,60));
                $est->setPromedio(rand(1000,2000)/100);
                
                $est->setPrimeraOpcion(rand(0,4));
                $est->setSegundaOpcion(rand(0,4));
                $est->setGenero(rand(0,1));
                $est->setEsAsignadoOPSU(rand(0,1));
                $est->setGestionPlantel(rand(0,1));
                $est->setTipoPlantel(rand(0,4));
                $est->setNivelSocioeconomico(rand(0,2));
                $est->setNivelEstudioPadres(rand(0,4));
                if ($i < 17 ) {//Estudiantes en estado Verificado
                    $est->setEstado(Estudiante::VERIFICADO);
                } elseif ($i < 34) {//Estudiantes en estado Datos Invalidos
                    $est->setEstado(Estudiante::DATOS_INVALIDOS);
                }else{//Estudiante en estado Pendiente
                    $est->setEstado(Estudiante::PENDIENTE);
                } 

                $est->setUsuario($user);

                $manager->persist($est);
                $manager->flush();
            }
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