<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 * 
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 1/02/2016
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UsuarioRepository")
 * @UniqueEntity(fields={"email", "username"})
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
        // tu propia lógica
    }

    /**
     * Implementación de una lista de roles para los usuarios 
     * 
     * @throws Exception
     * @param Rol $rol 
     */
    public function addRole($rol)
    {
        switch($rol){
            case 1:
                array_push($this->roles, 'ROLE_ESTUDIANTE');
                break;
            case 2:
                array_push($this->roles, 'ROLE_ADMIN');
                break;
            default:
                array_push($this->roles, 'ROLE_ESTUDIANTE');
                break;
        }
    }      
    /**
     * 
     * @throws Exception
     * @param array $roles 
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    } 
}
