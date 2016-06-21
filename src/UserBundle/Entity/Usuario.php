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
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UsuarioRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $created;


    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     */
    private $updated;

    public function __construct()
    {
        parent::__construct();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        // tu propia lógica
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Usuario
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PostPersist()
     */
    public function postCreated()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }
    /**
     * @ORM\PostUpdate()
     */
    public function postUpdated()
    {
        $this->updated = new \DateTime();
    }
}
