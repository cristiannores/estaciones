<?php

namespace Mappers\Model\RolJerarquia;

use Mappers\Model\RolJerarquia\RolJerarquia;

class RolJerarquia
{

    protected $rol_id = null;

    protected $padre_id = null;

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
     * Setea el parametro padre_id
     *
     * @param int $padre_id
     */
    public function setPadre_id($padre_id)
    {
        $this->padre_id = $padre_id;
    }

    /**
     * Retorna el parametro padre_id
     *
     * @return string
     */
    public function getPadre_id()
    {
        return $this->padre_id;
    }


}

