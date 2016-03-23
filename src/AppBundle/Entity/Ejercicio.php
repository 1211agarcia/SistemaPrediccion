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
     * @ORM\Column(name="nivel", type="integer")
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255)
     */
    private $categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=255)
     */
    private $tema;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Solucion")
     * @ORM\JoinTable(name="soluciones",
     *      joinColumns={@ORM\JoinColumn(name="ejercicio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="solucion_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     * @Assert\Count(
     *      min = "1",
     *      max = "5",
     *      minMessage = "Debe tener al menos 1 solucion",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Soluciones"
     * )
     */
    private $soluciones;

    /**
     * @var \Solucion
     *
     * @ORM\OneToOne(targetEntity="Solucion")
     * @ORM\JoinColumn(name="solucionDetallada_id", referencedColumnName="id")
     */
    private $solucionDetallada;

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
     * Set nivel
     *
     * @param integer $nivel
     * @return Ejercicio
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer 
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Ejercicio
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set tema
     *
     * @param string $tema
     * @return Ejercicio
     */
    public function setTema($tema)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return string 
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set soluciones
     *
     * @param array $soluciones
     * @return Ejercicio
     */
    public function setSoluciones($soluciones)
    {
        $this->soluciones = $soluciones;

        return $this;
    }

    /**
     * Get soluciones
     *
     * @return array 
     */
    public function getSoluciones()
    {
        return $this->soluciones;
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
     * Add soluciones
     *
     * @param \AppBundle\Entity\Solucion $soluciones
     * @return Ejercicio
     */
    public function addSolucione(\AppBundle\Entity\Solucion $soluciones)
    {
        $this->soluciones[] = $soluciones;

        return $this;
    }

    /**
     * Remove soluciones
     *
     * @param \AppBundle\Entity\Solucion $soluciones
     */
    public function removeSolucione(\AppBundle\Entity\Solucion $soluciones)
    {
        $this->soluciones->removeElement($soluciones);
    }
}
