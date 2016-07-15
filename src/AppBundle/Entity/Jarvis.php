<?php
/********************
 * Controlador de solicitudes inteligentes e intereaccion con sistemas inteligentes
 * Controlador de Peticiones de Apoyo inteligente
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */


namespace AppBundle\Entity;

/**
 * respuesta
 *
 */
class Jarvis
{
    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $expresion;

    /**
     * @var boolean
     *
     */
    private $correcta;

    /**
     * @var \Tema
     *
     */
    private $tema;

    public function __toString()
    {
        return sprintf($this->expresion);
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
     * Set tema
     *
     * @param \AppBundle\Entity\Tema $tema
     * @return Solucion
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
     * Set correcta
     *
     * @param boolean $correcta
     * @return Respuesta
     */
    public function setCorrecta($correcta)
    {
        $this->correcta = $correcta;

        return $this;
    }

    /**
     * Get correcta
     *
     * @return boolean 
     */
    public function getCorrecta()
    {
        return $this->correcta;
    }
}
