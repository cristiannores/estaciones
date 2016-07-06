<?php

namespace Mappers\Mapper\Indicadores;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Indicadores\Indicadores;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $indicadoresPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $indicadoresPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->indicadoresPrototype = $indicadoresPrototype;
    }

    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('indicadores');
        $select->where(array('id = ?' => $id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->indicadoresPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('indicadores');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->indicadoresPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Indicadores $indicadoresObject)
    {
        $indicadoresData = $this->hydrator->extract($indicadoresObject);
        $action = new Insert('indicadores');
        $action->values($indicadoresData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$indicadoresObject->setId($newId);
        	}
        	return $indicadoresObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Indicadores $indicadoresObject)
    {
        if($indicadoresObject instanceof Indicadores){
        	$action = new Delete("indicadores");
        	$action->where(array('id = ?' => $indicadoresObject->getId()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

