<?php

namespace Mappers\Service\Usuario;

use Mappers\Mapper\Usuario\ZendDbSqlMapper;

class UsuarioService
{

    protected $usuarioMapper = null;

    public function __construct($usuarioMapper)
    {
        $this->usuarioMapper = $usuarioMapper;
    }

    public function find($correo)
    {
        return $this->usuarioMapper->find($correo);
    }

    public function findAll()
    {
        return $this->usuarioMapper->findAll();
    }

    public function insert($UsuarioObject)
    {
        return $this->usuarioMapper->insert($UsuarioObject);
    }

    public function delete($UsuarioObject)
    {
        return $this->usuarioMapper->delete($UsuarioObject);
    }
    
    public function listarUsuarios(){
        return $this->usuarioMapper->listarUsuarios();
    }


}

