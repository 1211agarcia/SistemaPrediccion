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
    const DIFICULTADES = array(
        /*0*/"Principiante",
        /*1*/"Novato",
        /*2*/"Dificil",
        /*3*/"Muy dificil",
        /*4*/"Experto");
    const ESTADOS = array(
        /*0*/"Inactivo",
        /*1*/"Activo");

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
     * @Assert\NotNull(message="Al parecer esta ingresado la dificultad incorrecta")
     * @Assert\NotBlank(message="Creo que olvido indicar la dificultad")
     */
    private $dificultad;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $estado;
    
    /**
     * @var \Tema
     *
     * @ORM\ManyToOne(targetEntity="Tema")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", unique=false)
     * @Assert\NotNull(message="Debe seleccionar un tema incorrecto")
     * @Assert\NotBlank(message="Debe seleccionar un tema")
     */
    private $tema;

    /**
     * @var \ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Respuesta", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="ejercicios_respuesta",
     *      joinColumns={@ORM\JoinColumn(name="ejercicio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="respuesta_id", referencedColumnName="id", unique=true)}
     *      )
     * @Assert\Valid
     * @Assert\Count(
     *      min = "4",
     *      max = "50",
     *      minMessage = "Debe tener al menos {{ limit }} respuesta",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} respuestas"
     * )
     */
    private $respuestas;

    /**
     * @var string
     *
     * @ORM\Column(name="enunciado", type="text")
     * @Assert\NotNull(message="Al parecer esta ingresado el enunciado incorrecta")
     * @Assert\NotBlank(message="Creo que olvido indicar el enunciado")
     */
    private $enunciado;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
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
     * Get dificultad tex
     *
     * @return string
     */
    public function getDificultadString()
    {
        return self::DIFICULTADES[$this->dificultad];
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
     * Add respuesta
     *
     * @param \AppBundle\Entity\Respuesta $respuesta
     * @return Ejercicio
     */
    public function addRespuesta(\AppBundle\Entity\Respuesta $respuesta)
    {
        $this->respuestas[] = $respuesta;

        return $this;
    }

    /**
     * Remove respuesta
     *
     * @param \AppBundle\Entity\Respuesta $respuesta
     */
    public function removeRespuesta(\AppBundle\Entity\Respuesta $respuesta)
    {
        $this->respuestas->removeElement($respuesta);
    }

    /**
     * Remove respuestas
     *
     */
    public function removeAllRespuestas()
    {
        $this->respuestas->clear();
    }

    /**
     * Set respuestas
     *
     * @param array
     * @return Ejercicio
     */
    public function setRespuestas(array $respuestas)
    {/*   $this->removeAllRespuestas();
        $this->respuestas = new ArrayCollection();
        foreach ($respuestas as $value) {
            $this->respuestas[] = $value;
        }*/
        $this->respuestas = $respuestas;
        return $this;
    }
    /**
     * Get respuestas
     *
     * @return \ArrayCollection
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }
    /**
     * Get incorrectas
     *
     * @return array
     */
    public function getIncorrectas()
    {
        $incorrectas = array();
        foreach ($this->respuestas as $key => $value) {
            if(!$value->getCorrecta()){
                $incorrectas[] = $value;
            }
        }
        return $incorrectas;
    }
    /**
     * Get correcta
     *
     * @return \AppBundle\Entity\Respuesta
     */
    public function getCorrecta()
    {
        foreach ($this->respuestas as $key => $value) {
            if($value->getCorrecta()){
                return $value;
            }
        }
        return null;
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
     * Set estado
     *
     * @param boolean $estado
     * @return Ejercicio
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
}
