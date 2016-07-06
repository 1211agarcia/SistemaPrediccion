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
     * @ORM\ManyToOne(targetEntity="Tema", inversedBy="cursos")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $tema;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\Estudiante", inversedBy="cursos")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $estudiante;

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

    
}
