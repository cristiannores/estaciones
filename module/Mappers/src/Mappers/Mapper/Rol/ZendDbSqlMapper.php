<?php

namespace Mappers\Mapper\Rol;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Rol\Rol;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $rolPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $rolPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->rolPrototype = $rolPrototype;
    }

    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('rol');
        $select->where(array('id = ?' => $id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->rolPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('rol');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->rolPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Rol $rolObject)
    {
        $rolData = $this->hydrator->extract($rolObject);
        $action = new Insert('rol');
        $action->values($rolData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$rolObject->setId($newId);
        	}
        	return $rolObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Rol $rolObject)
    {
        if($rolObject instanceof Rol){
        	$action = new Delete("rol");
        	$action->where(array('id = ?' => $rolObject->getId()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

