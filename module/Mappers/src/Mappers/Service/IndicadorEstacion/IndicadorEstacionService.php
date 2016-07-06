<?php

namespace Mappers\Service\IndicadorEstacion;

use Mappers\Mapper\IndicadorEstacion\ZendDbSqlMapper;

class IndicadorEstacionService
{

    protected $indicadorEstacionMapper = null;

    public function __construct($indicadorEstacionMapper)
    {
        $this->indicadorEstacionMapper = $indicadorEstacionMapper;
    }

    public function find($id_indicador, $id_estacion, $fecha)
    {
        return $this->indicadorEstacionMapper->find($id_indicador,$id_estacion,$fecha);
    }

    public function findAll()
    {
        return $this->indicadorEstacionMapper->findAll();
    }

    public function insert($IndicadorEstacionObject)
    {
        return $this->indicadorEstacionMapper->insert($IndicadorEstacionObject);
    }

    public function delete($IndicadorEstacionObject)
    {
        return $this->indicadorEstacionMapper->delete($IndicadorEstacionObject);
    }


}

