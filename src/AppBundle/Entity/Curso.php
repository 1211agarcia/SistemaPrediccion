<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CursoRepository")
 */
class Curso
{
    const ESTADOS = array(
        /*0*/"Aprobado",
        /*1*/"Sin Aprobar");
    const APROBADO = TRUE;
    const NO_APROBADO = FALSE;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tema")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", unique=false)
     */
    private $tema;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Estudiante", inversedBy="cursos")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id", nullable=FALSE)
     */
    private $estudiante;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $estado;
    
    public function __construct()
    {
        $this->estado = self::NO_APROBADO;
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
     * Set estado
     *
     * @param boolean $estado
     * @return Curso
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tema
     *
     * @param \AppBundle\Entity\Tema $tema
     * @return Curso
     */
    public function setTema(\AppBundle\Entity\Tema $tema)
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
     * Set estudiante
     *
     * @param \UserBundle\Entity\Estudiante $estudiante
     * @return Curso
     */
    public function setEstudiante(\UserBundle\Entity\Estudiante $estudiante)
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
}
