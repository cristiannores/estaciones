<?php

namespace Mappers\Model\Indicadores;

use Mappers\Model\Indicadores\Indicadores;

class Indicadores
{

    protected $id = null;

    protected $atrIndicador = null;

    protected $habilitado = null;

    protected $fecha_vigencia_inicio = null;

    protected $fecha_vigencia_fin = null;

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
     * Setea el parametro atrIndicador
     *
     * @param int $atrIndicador
     */
    public function setAtrIndicador($atrIndicador)
    {
        $this->atrIndicador = $atrIndicador;
    }

    /**
     * Retorna el parametro atrIndicador
     *
     * @return string
     */
    public function getAtrIndicador()
    {
        return $this->atrIndicador;
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
     * Setea el parametro fecha_vigencia_inicio
     *
     * @param Zend/Date $fecha_vigencia_inicio
     */
    public function setFecha_vigencia_inicio($fecha_vigencia_inicio)
    {
        $this->fecha_vigencia_inicio = $fecha_vigencia_inicio;
    }

    /**
     * Retorna el parametro fecha_vigencia_inicio
     *
     * @return string
     */
    public function getFecha_vigencia_inicio()
    {
        return $this->fecha_vigencia_inicio;
    }

    /**
     * Setea el parametro fecha_vigencia_fin
     *
     * @param Zend/Date $fecha_vigencia_fin
     */
    public function setFecha_vigencia_fin($fecha_vigencia_fin)
    {
        $this->fecha_vigencia_fin = $fecha_vigencia_fin;
    }

    /**
     * Retorna el parametro fecha_vigencia_fin
     *
     * @return string
     */
    public function getFecha_vigencia_fin()
    {
        return $this->fecha_vigencia_fin;
    }


}

