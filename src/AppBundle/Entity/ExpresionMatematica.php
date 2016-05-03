<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * expresionMatematica
 *
 * @ORM\Table(name="expresion_matematica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpresionMatematicaRepository")
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
     * @Assert\NotNull(message="Debe ingresar Expresión")
     * @ORM\Column(name="expresion", type="string", length=255, unique=true, nullable=false)
     */
    private $expresion;

    /**
     * @var \Tema
     *
     * @Assert\NotNull(message="Debe indicar Tema de Expresión")
     * @ORM\ManyToOne(targetEntity="Tema")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", nullable=false, unique=false)
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
