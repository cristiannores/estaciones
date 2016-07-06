<?php

namespace Mappers\Mapper\Estacion;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Estacion\Estacion;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $estacionPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $estacionPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->estacionPrototype = $estacionPrototype;
    }

    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('estacion');
        $select->where(array('id = ?' => $id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->estacionPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('estacion');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->estacionPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Estacion $estacionObject)
    {
        $estacionData = $this->hydrator->extract($estacionObject);
        $action = new Insert('estacion');
        $action->values($estacionData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$estacionObject->setId($newId);
        	}
        	return $estacionObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Estacion $estacionObject)
    {
        if($estacionObject instanceof Estacion){
        	$action = new Delete("estacion");
        	$action->where(array('id = ?' => $estacionObject->getId()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

