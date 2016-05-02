<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ejercicio
 *
 * @ORM\Table(name="ejercicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EjercicioRepository")
 */
class Ejercicio
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
     * @var int
     *
     * @ORM\Column(name="dificultad", type="integer")
     */
    private $dificultad;

    /**
     * @var \Tema
     *
     * @ORM\OneToOne(targetEntity="Tema")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", unique=false)
     */
    private $tema;

    /**
     * @var \ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ExpresionMatematica", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="ejercicios_soluciones",
     *      joinColumns={@ORM\JoinColumn(name="ejercicio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="expresion_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     * @Assert\Count(
     *      min = "1",
     *      max = "5",
     *      minMessage = "Debe tener al menos 1 solución",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Soluciones"
     * )
     */
    private $soluciones;

    /**
     * @var string
     *
     * @ORM\Column(name="solucionDetallada", type="text")
     */
    private $solucionDetallada;

    /**
     * @var string
     *
     * @ORM\Column(name="enunciado", type="text")
     */
    private $enunciado;

    public function __construct()
    {
        $this->soluciones = new ArrayCollection();
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
     * Set dificultad
     *
     * @param integer $dificultad
     * @return Ejercicio
     */
    public function setDificultad($dificultad)
    {
        $this->dificultad = $dificultad;

        return $this;
    }

    /**
     * Get dificultad
     *
     * @return integer 
     */
    public function getDificultad()
    {
        return $this->dificultad;
    }

    /**
     * Set solucionDetallada
     *
     * @param string $solucionDetallada
     * @return Ejercicio
     */
    public function setSolucionDetallada($solucionDetallada)
    {
        $this->solucionDetallada = $solucionDetallada;

        return $this;
    }

    /**
     * Get solucionDetallada
     *
     * @return string 
     */
    public function getSolucionDetallada()
    {
        return $this->solucionDetallada;
    }

    /**
     * Set tema
     *
     * @param \AppBundle\Entity\Tema $tema
     * @return Ejercicio
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

    /**
     * Add solucion
     *
     * @param \AppBundle\Entity\ExpresionMatematica $solucion
     * @return Ejercicio
     */
    public function addSolucion(\AppBundle\Entity\ExpresionMatematica $solucion)
    {
        $this->soluciones[] = $solucion;

        return $this;
    }

    /**
     * Remove solucion
     *
     * @param \AppBundle\Entity\ExpresionMatematica $solucion
     */
    public function removeSolucione(\AppBundle\Entity\ExpresionMatematica $solucion)
    {
        $this->soluciones->removeElement($solucion);
    }

    /**
     * Remove Soluciones
     *
     */
    public function removeAllSoluciones()
    {
        $this->soluciones->clear();
    }

    /**
     * Get soluciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSoluciones()
    {
        return $this->soluciones;
    }

    /**
     * Set enunciado
     *
     * @param string $enunciado
     * @return Ejercicio
     */
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;

        return $this;
    }

    /**
     * Get enunciado
     *
     * @return string 
     */
    public function getEnunciado()
    {
        return $this->enunciado;
    }

    /**
     * Add soluciones
     *
     * @param \AppBundle\Entity\ExpresionMatematica $soluciones
     * @return Ejercicio
     */
    public function addSolucione(\AppBundle\Entity\ExpresionMatematica $soluciones)
    {
        $this->soluciones[] = $soluciones;

        return $this;
    }
}
