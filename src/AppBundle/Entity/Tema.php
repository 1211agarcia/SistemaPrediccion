<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $categorias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection(array(new Categoria()));
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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }
}
