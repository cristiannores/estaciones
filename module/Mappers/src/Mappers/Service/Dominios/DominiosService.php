<?php

namespace Mappers\Service\Dominios;

use Mappers\Mapper\Dominios\ZendDbSqlMapper;

class DominiosService
{

    protected $dominiosMapper = null;

    public function __construct($dominiosMapper)
    {
        $this->dominiosMapper = $dominiosMapper;
    }

    public function find($cod_atributo, $glo_atributo)
    {
        return $this->dominiosMapper->find($cod_atributo,$glo_atributo);
    }

    public function findAll()
    {
        return $this->dominiosMapper->findAll();
    }

    public function insert($DominiosObject)
    {
        return $this->dominiosMapper->insert($DominiosObject);
    }

    public function delete($DominiosObject)
    {
        return $this->dominiosMapper->delete($DominiosObject);
    }


}

