<?php

namespace Mappers\Model\IndicadorEstacion;

use Mappers\Model\IndicadorEstacion\IndicadorEstacion;

class IndicadorEstacion
{

    protected $id_indicador = null;

    protected $id_estacion = null;

    protected $valor = null;

    protected $fecha = null;

    /**
     * Setea el parametro id_indicador
     *
     * @param int $id_indicador
     */
    public function setId_indicador($id_indicador)
    {
        $this->id_indicador = $id_indicador;
    }

    /**
     * Retorna el parametro id_indicador
     *
     * @return string
     */
    public function getId_indicador()
    {
        return $this->id_indicador;
    }

    /**
     * Setea el parametro id_estacion
     *
     * @param int $id_estacion
     */
    public function setId_estacion($id_estacion)
    {
        $this->id_estacion = $id_estacion;
    }

    /**
     * Retorna el parametro id_estacion
     *
     * @return string
     */
    public function getId_estacion()
    {
        return $this->id_estacion;
    }

    /**
     * Setea el parametro valor
     *
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Retorna el parametro valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Setea el parametro fecha
     *
     * @param Zend/Date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Retorna el parametro fecha
     *
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }


}

