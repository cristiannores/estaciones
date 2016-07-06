<?php

namespace Mappers\Mapper\EstacionUsuario;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\EstacionUsuario\EstacionUsuario;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $estacionUsuarioPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $estacionUsuarioPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->estacionUsuarioPrototype = $estacionUsuarioPrototype;
    }

    public function find($correo_usuario, $id_estacion)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('estacion_usuario');
        $select->where(array('correo_usuario = ?' => $correo_usuario,'id_estacion = ?' => $id_estacion));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->estacionUsuarioPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('estacion_usuario');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->estacionUsuarioPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(EstacionUsuario $estacionUsuarioObject)
    {
        $estacionUsuarioData = $this->hydrator->extract($estacionUsuarioObject);
        $action = new Insert('estacion_usuario');
        $action->values($estacionUsuarioData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$estacionUsuarioObject->setId($newId);
        	}
        	return $estacionUsuarioObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(EstacionUsuario $estacionUsuarioObject)
    {
        if($estacionUsuarioObject instanceof EstacionUsuario){
        	$action = new Delete("estacion_usuario");
        	$action->where(array('correo_usuario = ?' => $estacionUsuarioObject->getCorreo_usuario(),'id_estacion = ?' => $estacionUsuarioObject->getId_estacion()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

