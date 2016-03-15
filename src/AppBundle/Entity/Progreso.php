<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\Estudiante;

/**
 * Progreso
 *
 * @ORM\Table(name="progreso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgresoRepository")
 */
class Progreso
{
    /**
     * @var \UserBundle\Entity\Estudiante
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Estudiante")
     */
    private $estudiante;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="primerEntrenamiento", type="datetimetz")
     */
    private $primerEntrenamiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimoEntrenamiento", type="datetimetz")
     */
    private $ultimoEntrenamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="primerEstado", type="string", length=255)
     */
    private $primerEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="pronostico", type="string", length=255)
     */
    private $pronostico;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->estudiante->getId();
    }

    /**
     * Set estudiante
     *
     * @param \UserBundle\Entity\Estudiante $estudiante
     * @return Progreso
     */
    public function setEstudiante(\UserBundle\Entity\Estudiante $estudiante = null)
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    /**
     * Get estudiante
     *
     * @return \UserBundle\Entity\Estudiante 
     */
    public function getEstudiante()
    {
        return $this->estudiante;
    }

    /**
     * Set primerEntrenamiento
     *
     * @param \DateTime $primerEntrenamiento
     * @return Progreso
     */
    public function setPrimerEntrenamiento($primerEntrenamiento)
    {
        $this->primerEntrenamiento = $primerEntrenamiento;

        return $this;
    }

    /**
     * Get primerEntrenamiento
     *
     * @return \DateTime 
     */
    public function getPrimerEntrenamiento()
    {
        return $this->primerEntrenamiento;
    }

    /**
     * Set ultimoEntrenamiento
     *
     * @param \DateTime $ultimoEntrenamiento
     * @return Progreso
     */
    public function setUltimoEntrenamiento($ultimoEntrenamiento)
    {
        $this->ultimoEntrenamiento = $ultimoEntrenamiento;

        return $this;
    }

    /**
     * Get ultimoEntrenamiento
     *
     * @return \DateTime 
     */
    public function getUltimoEntrenamiento()
    {
        return $this->ultimoEntrenamiento;
    }

    /**
     * Set primerEstado
     *
     * @param string $primerEstado
     * @return Progreso
     */
    public function setPrimerEstado($primerEstado)
    {
        $this->primerEstado = $primerEstado;

        return $this;
    }

    /**
     * Get primerEstado
     *
     * @return string 
     */
    public function getPrimerEstado()
    {
        return $this->primerEstado;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Progreso
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set pronostico
     *
     * @param string $pronostico
     * @return Progreso
     */
    public function setPronostico($pronostico)
    {
        $this->pronostico = $pronostico;

        return $this;
    }

    /**
     * Get pronostico
     *
     * @return string 
     */
    public function getPronostico()
    {
        return $this->pronostico;
    }
}
