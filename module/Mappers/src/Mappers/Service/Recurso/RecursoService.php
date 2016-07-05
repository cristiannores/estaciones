<?php

namespace Mappers\Service\Recurso;

use Mappers\Mapper\Recurso\ZendDbSqlMapper;

class RecursoService
{

    protected $recursoMapper = null;

    public function __construct($recursoMapper)
    {
        $this->recursoMapper = $recursoMapper;
    }

    public function find($id)
    {
        return $this->recursoMapper->find($id);
    }

    public function findAll()
    {
        return $this->recursoMapper->findAll();
    }

    public function insert($RecursoObject)
    {
        return $this->recursoMapper->insert($RecursoObject);
    }

    public function delete($RecursoObject)
    {
        return $this->recursoMapper->delete($RecursoObject);
    }


}

