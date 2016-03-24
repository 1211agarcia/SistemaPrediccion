<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * expresionMatematicaSolucion
 *
 * @ORM\Table(name="expresion_matematica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\expresionMatematicaSolucionRepository")
 */
class ExpresionMatematica
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="expresion", type="string", length=255, unique=true)
     */
    private $expresion;

    /**
     * @var \Tema
     *
     * @ORM\OneToOne(targetEntity="Tema")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id")
     */
    private $tema;

    public function __toString()
    {
        return sprintf($this->expresion);
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
     * Set expresion
     *
     * @param string $expresion
     * @return Solucion
     */
    public function setExpresion($expresion)
    {
        $this->expresion = $expresion;

        return $this;
    }

    /**
     * Get expresion
     *
     * @return string 
     */
    public function getExpresion()
    {
        return $this->expresion;
    }

    /**
     * Set tema
     *
     * @param \AppBundle\Entity\Tema $tema
     * @return Solucion
     */
    public function setTema(\AppBundle\Entity\Tema $tema = null)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return \AppBundle\Entity\Tema 
     */
    public function getTema()
    {
        return $this->tema;
    }
}
