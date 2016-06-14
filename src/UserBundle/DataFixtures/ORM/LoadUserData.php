<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\usuario as User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
        $user = new User();
        $user->setUserName('admin');
        $user->setEmail('admin'.'@facyt.uc.edu.ve');
        $user->setPlainPassword('123456');
        $user->addRole('ROLE_ADMIN');
        $user->setEnabled(true);
        $manager->persist($user);
        $manager->flush();
        $user = new User();
        $user->setUserName('profesor');
        $user->setEmail('profesor'.'@facyt.uc.edu.ve');
        $user->setPlainPassword('123456');
        $user->addRole('ROLE_PROFESOR');
        $user->setEnabled(true);
        $manager->persist($user);
        $manager->flush();
        $user = new User();
        $user->setUserName('verificador');
        $user->setEmail('verificador'.'@facyt.uc.edu.ve');
        $user->setPlainPassword('123456');
        $user->addRole('ROLE_VERIFICADOR');
        $user->setEnabled(true);
        $manager->persist($user);
        $manager->flush();
        

        for ($i=1; $i <= 50 ; $i++) { 
           
            $user = new User();
            $user->setUserName('estudiante'.$i);
            $user->setEmail('estudiante'.$i.'@facyt.uc.edu.ve');
            $user->setPlainPassword('123456');
            $user->addRole('ROLE_ESTUDIANTE');
            $user->setEnabled(true);
            $manager->persist($user);
            $manager->flush();
        }
    }
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 1;
    }
}