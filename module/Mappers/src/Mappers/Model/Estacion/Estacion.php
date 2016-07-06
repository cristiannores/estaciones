<?php

namespace Mappers\Model\Estacion;

use Mappers\Model\Estacion\Estacion;

class Estacion
{

    protected $id = null;

    protected $nombre = '';

    protected $habilitado = null;

    protected $ubicacion = '';

    protected $coordenadas = '';

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
     * @param int $habilitado
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
     * Setea el parametro ubicacion
     *
     * @param string $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * Retorna el parametro ubicacion
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Setea el parametro coordenadas
     *
     * @param string $coordenadas
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;
    }

    /**
     * Retorna el parametro coordenadas
     *
     * @return string
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }


}

