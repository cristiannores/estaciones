<?php

namespace Mappers\Model\Rol;

use Mappers\Model\Rol\Rol;

class Rol
{

    protected $id = null;

    protected $nombre = '';

    protected $habilitado = null;

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


}

