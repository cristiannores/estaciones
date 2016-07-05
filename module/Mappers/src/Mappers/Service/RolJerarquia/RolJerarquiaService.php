<?php

namespace Mappers\Service\RolJerarquia;

use Mappers\Mapper\RolJerarquia\ZendDbSqlMapper;

class RolJerarquiaService
{

    protected $rolJerarquiaMapper = null;

    public function __construct($rolJerarquiaMapper)
    {
        $this->rolJerarquiaMapper = $rolJerarquiaMapper;
    }

    public function find($rol_id, $padre_id)
    {
        return $this->rolJerarquiaMapper->find($rol_id,$padre_id);
    }

    public function findAll()
    {
        return $this->rolJerarquiaMapper->findAll();
    }

    public function insert($RolJerarquiaObject)
    {
        return $this->rolJerarquiaMapper->insert($RolJerarquiaObject);
    }

    public function delete($RolJerarquiaObject)
    {
        return $this->rolJerarquiaMapper->delete($RolJerarquiaObject);
    }


}

