<?php

namespace Mappers\Model\Dominios;

use Mappers\Model\Dominios\Dominios;

class Dominios
{

    protected $cod_atributo = '';

    protected $valor = null;

    protected $glo_atributo = '';

    /**
     * Setea el parametro cod_atributo
     *
     * @param string $cod_atributo
     */
    public function setCod_atributo($cod_atributo)
    {
        $this->cod_atributo = $cod_atributo;
    }

    /**
     * Retorna el parametro cod_atributo
     *
     * @return string
     */
    public function getCod_atributo()
    {
        return $this->cod_atributo;
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
     * Setea el parametro glo_atributo
     *
     * @param string $glo_atributo
     */
    public function setGlo_atributo($glo_atributo)
    {
        $this->glo_atributo = $glo_atributo;
    }

    /**
     * Retorna el parametro glo_atributo
     *
     * @return string
     */
    public function getGlo_atributo()
    {
        return $this->glo_atributo;
    }


}

