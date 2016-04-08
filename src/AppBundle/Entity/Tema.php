<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Tema
 *
 * @ORM\Table(name="tema")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemaRepository")
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
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Categoria", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="temas_categorias",
     *      joinColumns={@ORM\JoinColumn(name="tema_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="categoria_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     * @Assert\Count(
     *      min = "1",
     *      max = "10",
     *      minMessage = "Debe tener al menos 1 Categoria",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Categorias"
     * )
     */
    private $categorias;

    /**
     * @ORM\ManyToMany(targetEntity="Tema", mappedBy="hijos")
     * @ORM\JoinTable(name="temas_hijos",
     *      joinColumns={@ORM\JoinColumn(name="tema_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tema_hijo_id", referencedColumnName="id")}
     *      )
     */
    private $padres;
    /**
     * @ORM\ManyToMany(targetEntity="Tema", inversedBy="padres")
     */
    private $hijos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorias = new ArrayCollection();
        
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
     * Add categorias
     *
     * @param \AppBundle\Entity\Categoria $categorias
     * @return Tema
     */
    public function addCategoria(\AppBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;

        return $this;
    }

    /**
     * Remove categorias
     *
     * @param \AppBundle\Entity\Categoria $categorias
     */
    public function removeCategoria(\AppBundle\Entity\Categoria $categorias)
    {
        $this->categorias->removeElement($categorias);
    }
    /**
     * Remove categorias
     *
     */
    public function removeAllCategorias()
    {
        $this->categorias->clear();
    }
    /**
     * Get categorias
     *
     * @return \ArrayCollection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Add padre
     *
     * @param \AppBundle\Entity\Tema $padre
     * @return Tema
     */
    public function addPadre(\AppBundle\Entity\Tema $padre)
    {
        $this->padres[] = $padre;

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
     * Add hijo
     *
     * @param \AppBundle\Entity\Tema $hijo
     * @return Tema
     */
    public function addHijo(\AppBundle\Entity\Tema $hijo)
    {
        $this->hijos[] = $hijo;

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

}
