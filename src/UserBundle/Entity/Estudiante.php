<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Estudiante
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\EstudianteRepository")
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

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer", unique=true, nullable=false)
     */
    private $cedula;
    
    /**
     * @var \UserBundle\Entity\Usuario
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Usuario")
     */
    protected $usuario;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Debe ingresar el nombre")
     */
    private $nombre;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Debe ingresar el apellido")
     */
    private $apellido;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $notaPrimero;
    /**
     * @var float
     *
     * @ORM\Column(type="decimal")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $notaSegundo;
    /**
     * @var float
     *
     * @ORM\Column(type="decimal")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $notaTercero;
    /**
     * @var float
     *
     * @ORM\Column(type="decimal")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $notaCuarto ;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar la cantidad de Materias cursadas en bachillerato")
     */
    private $cantMaterias;
    /**
     * @var float
     *
     * @ORM\Column(type="decimal")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $promedio;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $primeraOpcionOpsu;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $segundaOpcionOpsu;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $sexo;
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $tieneAccesoInternet;
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $esAsignadoOPSU;

    /**
     * @var 
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $gestionPlantel;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $tipoPlantel;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $nivelSocioeconomico;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Debe ingresar ")
     */
    private $nivelEstudioPadres;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->usuario->getId();
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
     * Set notaPrimero
     *
     * @param string $notaPrimero
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
     * @return string 
     */
    public function getNotaPrimero()
    {
        return $this->notaPrimero;
    }

    /**
     * Set notaSegundo
     *
     * @param string $notaSegundo
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
     * @return string 
     */
    public function getNotaSegundo()
    {
        return $this->notaSegundo;
    }

    /**
     * Set notaTercero
     *
     * @param string $notaTercero
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
     * @return string 
     */
    public function getNotaTercero()
    {
        return $this->notaTercero;
    }

    /**
     * Set notaCuarto
     *
     * @param string $notaCuarto
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
     * @return string 
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
     * @param string $promedio
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
     * @return string 
     */
    public function getPromedio()
    {
        return $this->promedio;
    }

    /**
     * Set primeraOpcionOpsu
     *
     * @param integer $primeraOpcionOpsu
     * @return Estudiante
     */
    public function setPrimeraOpcionOpsu($primeraOpcionOpsu)
    {
        $this->primeraOpcionOpsu = $primeraOpcionOpsu;

        return $this;
    }

    /**
     * Get primeraOpcionOpsu
     *
     * @return integer 
     */
    public function getPrimeraOpcionOpsu()
    {
        return $this->primeraOpcionOpsu;
    }

    /**
     * Set segundaOpcionOpsu
     *
     * @param integer $segundaOpcionOpsu
     * @return Estudiante
     */
    public function setSegundaOpcionOpsu($segundaOpcionOpsu)
    {
        $this->segundaOpcionOpsu = $segundaOpcionOpsu;

        return $this;
    }

    /**
     * Get segundaOpcionOpsu
     *
     * @return integer 
     */
    public function getSegundaOpcionOpsu()
    {
        return $this->segundaOpcionOpsu;
    }

    /**
     * Set sexo
     *
     * @param integer $sexo
     * @return Estudiante
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return integer 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set tieneAccesoInternet
     *
     * @param boolean $tieneAccesoInternet
     * @return Estudiante
     */
    public function setTieneAccesoInternet($tieneAccesoInternet)
    {
        $this->tieneAccesoInternet = $tieneAccesoInternet;

        return $this;
    }

    /**
     * Get tieneAccesoInternet
     *
     * @return boolean 
     */
    public function getTieneAccesoInternet()
    {
        return $this->tieneAccesoInternet;
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
}
