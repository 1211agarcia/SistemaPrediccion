<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tema
 *
 * @ORM\Table(name="tema")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemaRepository")
 * @UniqueEntity("nombre")
 */
class Tema
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity="Tema", inversedBy="padres")
     * @ORM\JoinTable(name="temas_hijos",
     *      joinColumns={@ORM\JoinColumn(name="tema_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tema_padre_id", referencedColumnName="id")}
     *      )
     */
    private $hijos;
    /**
     * @ORM\ManyToMany(targetEntity="Tema", mappedBy="hijos")
     */
    private $padres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->padres = new ArrayCollection();
        $this->hijos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Tema
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add padre
     *
     * @param \AppBundle\Entity\Tema $padre
     * @return Tema
     */
    public function addPadre(\AppBundle\Entity\Tema $padre)
    {
        if (!$this->padres->contains($padre)) {
            $this->padres[] = $padre;
        }

        return $this;
    }

    /**
     * Remove padre
     *
     * @param \AppBundle\Entity\Tema $padre
     */
    public function removePadre(\AppBundle\Entity\Tema $padre)
    {
        $this->padres->removeElement($padre);
    }

    /**
     * Get padres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPadres()
    {
        return $this->padres;
    }
    /**
     * Remove padres
     *
     */
    public function removeAllPadres()
    {
        $this->padres->clear();
    }

    /**
     * Add hijo
     *
     * @param \AppBundle\Entity\Tema $hijo
     * @return Tema
     */
    public function addHijo(\AppBundle\Entity\Tema $hijo)
    {
        if (!$this->hijos->contains($hijo)) {
            $this->hijos[] = $hijo;
        }

        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \AppBundle\Entity\Tema $hijos
     */
    public function removeHijo(\AppBundle\Entity\Tema $hijo)
    {
        $this->hijos->removeElement($hijo);
    }
    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHijos()
    {
        return $this->hijos;
    }


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tema
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
