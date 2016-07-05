<?php

namespace Mappers\Service\Privilegio;

use Mappers\Mapper\Privilegio\ZendDbSqlMapper;

class PrivilegioService
{

    protected $privilegioMapper = null;

    public function __construct($privilegioMapper)
    {
        $this->privilegioMapper = $privilegioMapper;
    }

    public function find($id)
    {
        return $this->privilegioMapper->find($id);
    }

    public function findAll()
    {
        return $this->privilegioMapper->findAll();
    }

    public function insert($PrivilegioObject)
    {
        return $this->privilegioMapper->insert($PrivilegioObject);
    }

    public function delete($PrivilegioObject)
    {
        return $this->privilegioMapper->delete($PrivilegioObject);
    }


}

