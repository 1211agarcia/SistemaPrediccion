<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Solucion
 *
 * @ORM\Table(name="solucion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SolucionRepository")
 */
class Solucion
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
     * @ORM\Column(name="expresion", type="string", length=255, unique=true)
     */
    private $expresion;

    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=255)
     */
    private $tema;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255)
     */
    private $categoria;

    /**
     * @var int
     *
     * @ORM\Column(name="nivel", type="integer")
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    public function __toString()
    {
        return $this->expresion;
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
     * Set body
     *
     * @param string $body
     * @return Solucion
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set tema
     *
     * @param string $tema
     * @return Solucion
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
     * Set categoria
     *
     * @param string $categoria
     * @return Solucion
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
     * Set tipo
     *
     * @param string $tipo
     * @return Solucion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set expresion
     *
     * @param string $expresion
     * @return Solucion
     */
    public function setExpresion($expresion)
    {
        $this->expresion = $expresion;

        return $this;
    }

    /**
     * Get expresion
     *
     * @return string 
     */
    public function getExpresion()
    {
        return $this->expresion;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return Solucion
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

}
