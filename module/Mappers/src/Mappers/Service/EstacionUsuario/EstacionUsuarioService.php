<?php

namespace Mappers\Service\EstacionUsuario;

use Mappers\Mapper\EstacionUsuario\ZendDbSqlMapper;

class EstacionUsuarioService
{

    protected $estacionUsuarioMapper = null;

    public function __construct($estacionUsuarioMapper)
    {
        $this->estacionUsuarioMapper = $estacionUsuarioMapper;
    }

    public function find($correo_usuario, $id_estacion)
    {
        return $this->estacionUsuarioMapper->find($correo_usuario,$id_estacion);
    }

    public function findAll()
    {
        return $this->estacionUsuarioMapper->findAll();
    }

    public function insert($EstacionUsuarioObject)
    {
        return $this->estacionUsuarioMapper->insert($EstacionUsuarioObject);
    }

    public function delete($EstacionUsuarioObject)
    {
        return $this->estacionUsuarioMapper->delete($EstacionUsuarioObject);
    }


}

