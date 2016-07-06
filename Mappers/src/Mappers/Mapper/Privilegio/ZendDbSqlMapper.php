<?php

namespace Mappers\Mapper\Privilegio;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Privilegio\Privilegio;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $privilegioPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $privilegioPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->privilegioPrototype = $privilegioPrototype;
    }

    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('privilegio');
        $select->where(array('id = ?' => $id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->privilegioPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('privilegio');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->privilegioPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Privilegio $privilegioObject)
    {
        $privilegioData = $this->hydrator->extract($privilegioObject);
        $action = new Insert('privilegio');
        $action->values($privilegioData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$privilegioObject->setId($newId);
        	}
        	return $privilegioObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Privilegio $privilegioObject)
    {
        if($privilegioObject instanceof Privilegio){
        	$action = new Delete("privilegio");
        	$action->where(array('id = ?' => $privilegioObject->getId()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

