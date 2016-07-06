<?php

namespace Mappers\Service\Estacion;

use Mappers\Mapper\Estacion\ZendDbSqlMapper;

class EstacionService
{

    protected $estacionMapper = null;

    public function __construct($estacionMapper)
    {
        $this->estacionMapper = $estacionMapper;
    }

    public function find($id)
    {
        return $this->estacionMapper->find($id);
    }

    public function findAll()
    {
        return $this->estacionMapper->findAll();
    }

    public function insert($EstacionObject)
    {
        return $this->estacionMapper->insert($EstacionObject);
    }

    public function delete($EstacionObject)
    {
        return $this->estacionMapper->delete($EstacionObject);
    }


}

