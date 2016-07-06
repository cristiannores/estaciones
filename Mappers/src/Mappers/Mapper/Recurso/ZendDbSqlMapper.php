<?php

namespace Mappers\Mapper\Recurso;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Recurso\Recurso;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $recursoPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $recursoPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->recursoPrototype = $recursoPrototype;
    }

    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('recurso');
        $select->where(array('id = ?' => $id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->recursoPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('recurso');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->recursoPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Recurso $recursoObject)
    {
        $recursoData = $this->hydrator->extract($recursoObject);
        $action = new Insert('recurso');
        $action->values($recursoData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$recursoObject->setId($newId);
        	}
        	return $recursoObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Recurso $recursoObject)
    {
        if($recursoObject instanceof Recurso){
        	$action = new Delete("recurso");
        	$action->where(array('id = ?' => $recursoObject->getId()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

