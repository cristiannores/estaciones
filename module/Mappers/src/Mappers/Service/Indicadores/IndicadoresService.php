<?php

namespace Mappers\Service\Indicadores;

use Mappers\Mapper\Indicadores\ZendDbSqlMapper;

class IndicadoresService
{

    protected $indicadoresMapper = null;

    public function __construct($indicadoresMapper)
    {
        $this->indicadoresMapper = $indicadoresMapper;
    }

    public function find($id)
    {
        return $this->indicadoresMapper->find($id);
    }

    public function findAll()
    {
        return $this->indicadoresMapper->findAll();
    }

    public function insert($IndicadoresObject)
    {
        return $this->indicadoresMapper->insert($IndicadoresObject);
    }

    public function delete($IndicadoresObject)
    {
        return $this->indicadoresMapper->delete($IndicadoresObject);
    }


}

