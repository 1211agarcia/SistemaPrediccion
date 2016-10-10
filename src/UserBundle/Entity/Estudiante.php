<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Estudiante
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\EstudianteRepository")
 * @UniqueEntity("cedula")
 * @UniqueEntity("usuario")
 */
class Estudiante
{
    const CARRERAS = array(
        /*0*/"Biología",
        /*1*/"Computación", 
        /*2*/"Física",
        /*3*/"Matemática",
        /*4*/"Química");
    const NIVELES_EDUCATIVOS = array(
        /*0*/"No hizo estudios/Escuela Primaria Incompleta",
        /*1*/"Escuela Primaria Completa/ Escuela Secundaria Incompleta",
        /*2*/"Escuela Secundaria Completa/Estudio Superior No Universitario Incompleto",
        /*3*/"Estudio Superior No Universistario Completo/Estudio Universitario Incompleto",
        /*4*/"Estudio Universitario Completo/Estudios de Posgrado");
    const NIVELES_SOCIOECONOMICOS = array(
        /*0*/"Bajo",
        /*1*/"Medio",
        /*2*/"Alto");
    const GESTIONES_PLANTEL = array(
        /*0*/"Público",
        /*1*/"Privado");
    const TIPOS_PLANTEL = array(
        /*0*/"Ciencias básicas",
        /*1*/"Escuela Técnica",
        /*2*/"Parasistemas ",
        /*3*/"Bachillerato integral",
        /*4*/"Institución militar");
    const PENDIENTE = 1;
    const DATOS_INVALIDOS = 2;
    const VERIFICADO = 3;
    const ESTADOS = array(
        1 => "Pendiente",
        2 => "Datos Invalidos",
        3 => "Verificado");
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer", unique=true, nullable=false)
     */
    private $cedula;
    
    /**
     * @var \UserBundle\Entity\Usuario
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="Usuario", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Debe ingresar el nombre")
     */
    private $nombre;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Debe ingresar el apellido")
     */
    private $apellido;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar primera nota de matemática")
     */
    private $notaPrimero;
    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar segunda nota de matemática")
     */
    private $notaSegundo;
    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar tercera nota de matemática")
     */
    private $notaTercero;
    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar cuarta nota de matemática")
     */
    private $notaCuarto;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar la cantidad de Materias cursadas en bachillerato")
     */
    private $cantMaterias;
    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar promedio")
     */
    private $promedio;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar primera opción")
     */
    private $primeraOpcion;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe ingresar segunda opción")
     */
    private $segundaOpcion;
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     * Assert\NotBlank(message="Debe indicar género")
     * @Assert\NotNull(message="El valor del género no puede ser 'nulo'")
     */
    private $genero;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     * Assert\NotBlank(message="Debe indicar si esta o no, asignado por la OPSU")
     * @Assert\NotNull(message="El valor de asignacion de Opsu no debe ser nulo")
     */
    private $esAsignadoOPSU;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe indicar la gestion del plantel")
     */
    private $gestionPlantel;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe indicar el tipo de plantel")
     */
    private $tipoPlantel;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe indicar nivel socioeconomico")
     */
    private $nivelSocioeconomico;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message="Debe indicar nivel de estudio de padres")
     */
    private $nivelEstudioPadres;

    /**
     * @var boolean
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Curso", mappedBy="estudiante")
     */
    private $cursos;
    
    /**
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Practica", mappedBy="estudiante")
     */
    private $practicas;

    /**
     * @var UploadedFile
     *
     * @ORM\Column(type="string", nullable=false)
     * Assert\File(
     *     maxSize = "20Mi",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor cargar un PDF valido",
     * )
     * @Assert\NotNull(message="El archivo de credenciales no puede ser 'nulo'.")
     * @Assert\NotBlank(message="Por favor, cargue sus credenciales como un archivo PDF.")
     */
    private $credencial;

    public function __construct()
    {
        //parent::__construct();
        $this->verificado = false;//SIN_VERIFICAR;
        $this->practicas = new ArrayCollection();
        $this->cursos = new ArrayCollection();
    }

    public function prediction_format_file()
    {
        return ($this->getNotaPrimero().' '.
        $this->getNotaSegundo().' '.
        $this->getNotaTercero().' '.
        $this->getNotaCuarto().' '.
        $this->getPromedio().' '.
        $this->getCantMaterias().' '.
        $this->getGestionPlantel().' '.
        $this->getTipoPlantel().' '.
        ($this->getEsAsignadoOPSU()? '1' : '0').' '.
        $this->getPrimeraOpcion().' '.
        $this->getSegundaOpcion().' '.
        $this->getNivelSocioeconomico().' '.
        $this->getNivelEstudioPadres().' '.
        ($this->getGenero()? '1' : '0').' ');
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
     * Set cedula
     *
     * @param integer $cedula
     * @return Estudiante
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return integer 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Estudiante
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
     * Set apellido
     *
     * @param string $apellido
     * @return Estudiante
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set notaPrimero
     *
     * @param float $notaPrimero
     * @return Estudiante
     */
    public function setNotaPrimero($notaPrimero)
    {
        $this->notaPrimero = $notaPrimero;

        return $this;
    }

    /**
     * Get notaPrimero
     *
     * @return float 
     */
    public function getNotaPrimero()
    {
        return $this->notaPrimero;
    }

    /**
     * Set notaSegundo
     *
     * @param float $notaSegundo
     * @return Estudiante
     */
    public function setNotaSegundo($notaSegundo)
    {
        $this->notaSegundo = $notaSegundo;

        return $this;
    }

    /**
     * Get notaSegundo
     *
     * @return float 
     */
    public function getNotaSegundo()
    {
        return $this->notaSegundo;
    }

    /**
     * Set notaTercero
     *
     * @param float $notaTercero
     * @return Estudiante
     */
    public function setNotaTercero($notaTercero)
    {
        $this->notaTercero = $notaTercero;

        return $this;
    }

    /**
     * Get notaTercero
     *
     * @return float 
     */
    public function getNotaTercero()
    {
        return $this->notaTercero;
    }

    /**
     * Set notaCuarto
     *
     * @param float $notaCuarto
     * @return Estudiante
     */
    public function setNotaCuarto($notaCuarto)
    {
        $this->notaCuarto = $notaCuarto;

        return $this;
    }

    /**
     * Get notaCuarto
     *
     * @return float 
     */
    public function getNotaCuarto()
    {
        return $this->notaCuarto;
    }

    /**
     * Set cantMaterias
     *
     * @param integer $cantMaterias
     * @return Estudiante
     */
    public function setCantMaterias($cantMaterias)
    {
        $this->cantMaterias = $cantMaterias;

        return $this;
    }

    /**
     * Get cantMaterias
     *
     * @return integer 
     */
    public function getCantMaterias()
    {
        return $this->cantMaterias;
    }

    /**
     * Set promedio
     *
     * @param float $promedio
     * @return Estudiante
     */
    public function setPromedio($promedio)
    {
        $this->promedio = $promedio;

        return $this;
    }

    /**
     * Get promedio
     *
     * @return float 
     */
    public function getPromedio()
    {
        return $this->promedio;
    }

    /**
     * Set primeraOpcion
     *
     * @param integer $primeraOpcion
     * @return Estudiante
     */
    public function setPrimeraOpcion($primeraOpcion)
    {
        $this->primeraOpcion = $primeraOpcion;

        return $this;
    }

    /**
     * Get primeraOpcion
     *
     * @return integer 
     */
    public function getPrimeraOpcion()
    {
        return $this->primeraOpcion;
    }

    /**
     * Set segundaOpcion
     *
     * @param integer $segundaOpcion
     * @return Estudiante
     */
    public function setSegundaOpcion($segundaOpcion)
    {
        $this->segundaOpcion = $segundaOpcion;

        return $this;
    }

    /**
     * Get segundaOpcion
     *
     * @return integer 
     */
    public function getSegundaOpcion()
    {
        return $this->segundaOpcion;
    }

    /**
     * Set genero
     *
     * @param boolean $genero
     * @return Estudiante
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return boolean 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set esAsignadoOPSU
     *
     * @param boolean $esAsignadoOPSU
     * @return Estudiante
     */
    public function setEsAsignadoOPSU($esAsignadoOPSU)
    {
        $this->esAsignadoOPSU = $esAsignadoOPSU;

        return $this;
    }

    /**
     * Get esAsignadoOPSU
     *
     * @return boolean 
     */
    public function getEsAsignadoOPSU()
    {
        return $this->esAsignadoOPSU;
    }

    /**
     * Set gestionPlantel
     *
     * @param integer $gestionPlantel
     * @return Estudiante
     */
    public function setGestionPlantel($gestionPlantel)
    {
        $this->gestionPlantel = $gestionPlantel;

        return $this;
    }

    /**
     * Get gestionPlantel
     *
     * @return integer 
     */
    public function getGestionPlantel()
    {
        return $this->gestionPlantel;
    }

    /**
     * Set tipoPlantel
     *
     * @param integer $tipoPlantel
     * @return Estudiante
     */
    public function setTipoPlantel($tipoPlantel)
    {
        $this->tipoPlantel = $tipoPlantel;

        return $this;
    }

    /**
     * Get tipoPlantel
     *
     * @return integer 
     */
    public function getTipoPlantel()
    {
        return $this->tipoPlantel;
    }

    /**
     * Set nivelSocioeconomico
     *
     * @param integer $nivelSocioeconomico
     * @return Estudiante
     */
    public function setNivelSocioeconomico($nivelSocioeconomico)
    {
        $this->nivelSocioeconomico = $nivelSocioeconomico;

        return $this;
    }

    /**
     * Get nivelSocioeconomico
     *
     * @return integer 
     */
    public function getNivelSocioeconomico()
    {
        return $this->nivelSocioeconomico;
    }

    /**
     * Set nivelEstudioPadres
     *
     * @param integer $nivelEstudioPadres
     * @return Estudiante
     */
    public function setNivelEstudioPadres($nivelEstudioPadres)
    {
        $this->nivelEstudioPadres = $nivelEstudioPadres;

        return $this;
    }

    /**
     * Get nivelEstudioPadres
     *
     * @return integer 
     */
    public function getNivelEstudioPadres()
    {
        return $this->nivelEstudioPadres;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Estudiante
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set usuario
     *
     * @param \UserBundle\Entity\Usuario $usuario
     * @return Estudiante
     */
    public function setUsuario(\UserBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \UserBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set credencial
     *
     * @param string $credencial
     * @return Estudiante
     */
    public function setCredencial($credencial)
    {
        $this->credencial = $credencial;

        return $this;
    }

    /**
     * Get credencial
     *
     * @return string 
     */
    public function getCredencial()
    {
        return $this->credencial;
    }

    /**
     * Add practicas
     *
     * @param \AppBundle\Entity\Practica $practicas
     * @return Estudiante
     */
    public function addPractica(\AppBundle\Entity\Practica $practicas)
    {
        $this->practicas[] = $practicas;

        return $this;
    }

    /**
     * Remove practicas
     *
     * @param \AppBundle\Entity\Practica $practicas
     */
    public function removePractica(\AppBundle\Entity\Practica $practicas)
    {
        $this->practicas->removeElement($practicas);
    }

    /**
     * Get practicas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPracticas()
    {
        return $this->practicas;
    }

    /**
     * Add cursos
     *
     * @param \AppBundle\Entity\Curso $cursos
     * @return Estudiante
     */
    public function addCurso(\AppBundle\Entity\Curso $cursos)
    {
        $this->cursos[] = $cursos;

        return $this;
    }

    /**
     * Remove cursos
     *
     * @param \AppBundle\Entity\Curso $cursos
     */
    public function removeCurso(\AppBundle\Entity\Curso $cursos)
    {
        $this->cursos->removeElement($cursos);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     *
     * Get progreso
     *
     * @return 
     */
    public function getProgreso()
    {
        $acum = 0;
        foreach ($this->practicas as $key => $value) {
            $acum += $value->getCalificacion();
        }
        if($acum === 0){
            $acum = 35 - ($this->cedula % 10);
            $acum *= 3;
            $acum += 1;
            $key = 1;
        }
        return number_format($acum / ($key + 1), 2);
    }
}
