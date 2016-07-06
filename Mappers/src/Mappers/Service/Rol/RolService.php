<?php

namespace Mappers\Service\Rol;

use Mappers\Mapper\Rol\ZendDbSqlMapper;

class RolService
{

    protected $rolMapper = null;

    public function __construct($rolMapper)
    {
        $this->rolMapper = $rolMapper;
    }

    public function find($id)
    {
        return $this->rolMapper->find($id);
    }

    public function findAll()
    {
        return $this->rolMapper->findAll();
    }

    public function insert($RolObject)
    {
        return $this->rolMapper->insert($RolObject);
    }

    public function delete($RolObject)
    {
        return $this->rolMapper->delete($RolObject);
    }


}

