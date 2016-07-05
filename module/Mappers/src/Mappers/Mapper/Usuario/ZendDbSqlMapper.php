<?php

namespace Mappers\Mapper\Usuario;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Usuario\Usuario;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $usuarioPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $usuarioPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->usuarioPrototype = $usuarioPrototype;
    }

    public function find($correo)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('usuario');
        $select->where(array('correo = ?' => $correo));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->usuarioPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('usuario');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->usuarioPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Usuario $usuarioObject)
    {
        $usuarioData = $this->hydrator->extract($usuarioObject);
        $action = new Insert('usuario');
        $action->values($usuarioData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$usuarioObject->setId($newId);
        	}
        	return $usuarioObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Usuario $usuarioObject)
    {
        if($usuarioObject instanceof Usuario){
        	$action = new Delete("usuario");
        	$action->where(array('correo = ?' => $usuarioObject->getCorreo()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }
    
    public function listarUsuarios(){
        
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->join(array('r' => 'rol'), "r.id = u.rol_id",array('rol' => 'nombre'));
        $select->from(array('u' => 'usuario'))->columns(array('nombres','ap_pat','ap_mat','correo','habilitado'));
        
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new \Zend\Db\ResultSet\ResultSet();
                $resultSet->initialize($result);
        	return $resultSet;
        }
        return array();
    }

}

