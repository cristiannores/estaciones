<?php

namespace Mappers\Mapper\Dominios;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\Dominios\Dominios;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $dominiosPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $dominiosPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->dominiosPrototype = $dominiosPrototype;
    }

    public function find($cod_atributo, $glo_atributo)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('dominios');
        $select->where(array('cod_atributo = ?' => $cod_atributo,'glo_atributo = ?' => $glo_atributo));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->dominiosPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('dominios');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->dominiosPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(Dominios $dominiosObject)
    {
        $dominiosData = $this->hydrator->extract($dominiosObject);
        $action = new Insert('dominios');
        $action->values($dominiosData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$dominiosObject->setId($newId);
        	}
        	return $dominiosObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(Dominios $dominiosObject)
    {
        if($dominiosObject instanceof Dominios){
        	$action = new Delete("dominios");
        	$action->where(array('cod_atributo = ?' => $dominiosObject->getCod_atributo(),'glo_atributo = ?' => $dominiosObject->getGlo_atributo()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

