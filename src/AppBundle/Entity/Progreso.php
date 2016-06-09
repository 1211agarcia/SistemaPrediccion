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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \UserBundle\Entity\Estudiante
     *
     * @ORM\OneToOne(targetEntity="\UserBundle\Entity\Estudiante", inversedBy="progreso")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id")
     */
    private $estudiante;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="primeraPractica", type="datetime")
     */
    private $primeraPractica;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimaPractica", type="datetime")
     */
    private $ultimaPractica;

    /**
     * @var string
     *
     * @ORM\Column(name="primerEstado", type="string", length=255)
     *
     * se refiere a la primera inicialización del progreso del estudiante luego de la predicción, esto para verificar si el progreso el estudiante ha ido en aumento o descenso.
     */
    private $primerEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     * no se ha definido el estado con relacion a los tema o arbol de temas, y la difusidadd entre oro, plata, y broce
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
     * Set primeraPractica
     *
     * @param \DateTime $primeraPractica
     * @return Progreso
     */
    public function setPrimeraPractica($primeraPractica)
    {
        $this->primeraPractica = $primeraPractica;

        return $this;
    }

    /**
     * Get primeraPractica
     *
     * @return \DateTime 
     */
    public function getPrimeraPractica()
    {
        return $this->primeraPractica;
    }

    /**
     * Set ultimaPractica
     *
     * @param \DateTime $ultimaPractica
     * @return Progreso
     */
    public function setUltimaPractica($ultimaPractica)
    {
        $this->ultimaPractica = $ultimaPractica;

        return $this;
    }

    /**
     * Get ultimaPractica
     *
     * @return \DateTime 
     */
    public function getUltimaPractica()
    {
        return $this->ultimaPractica;
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
