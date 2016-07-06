<?php

namespace Mappers\Model\EstacionUsuario;

use Mappers\Model\EstacionUsuario\EstacionUsuario;

class EstacionUsuario
{

    protected $correo_usuario = '';

    protected $id_estacion = null;

    protected $habilitado = null;

    protected $fecha_vigencia_inicio = null;

    protected $fecha_vigencia_fin = null;

    /**
     * Setea el parametro correo_usuario
     *
     * @param string $correo_usuario
     */
    public function setCorreo_usuario($correo_usuario)
    {
        $this->correo_usuario = $correo_usuario;
    }

    /**
     * Retorna el parametro correo_usuario
     *
     * @return string
     */
    public function getCorreo_usuario()
    {
        return $this->correo_usuario;
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

