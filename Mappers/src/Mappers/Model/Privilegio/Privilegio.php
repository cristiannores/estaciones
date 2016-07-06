<?php

namespace Mappers\Model\Privilegio;

use Mappers\Model\Privilegio\Privilegio;

class Privilegio
{

    protected $id = null;

    protected $nombre = '';

    protected $habilitado = null;

    protected $rol_id = null;

    protected $recurso_id = null;

    /**
     * Setea el parametro id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Retorna el parametro id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setea el parametro nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Retorna el parametro nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Setea el parametro habilitado
     *
     * @param string $habilitado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;
    }

    /**
     * Retorna el parametro habilitado
     *
     * @return string
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Setea el parametro rol_id
     *
     * @param int $rol_id
     */
    public function setRol_id($rol_id)
    {
        $this->rol_id = $rol_id;
    }

    /**
     * Retorna el parametro rol_id
     *
     * @return string
     */
    public function getRol_id()
    {
        return $this->rol_id;
    }

    /**
     * Setea el parametro recurso_id
     *
     * @param int $recurso_id
     */
    public function setRecurso_id($recurso_id)
    {
        $this->recurso_id = $recurso_id;
    }

    /**
     * Retorna el parametro recurso_id
     *
     * @return string
     */
    public function getRecurso_id()
    {
        return $this->recurso_id;
    }


}

