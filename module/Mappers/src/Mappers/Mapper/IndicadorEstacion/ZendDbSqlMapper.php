<?php

namespace Mappers\Mapper\IndicadorEstacion;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\IndicadorEstacion\IndicadorEstacion;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $indicadorEstacionPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $indicadorEstacionPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->indicadorEstacionPrototype = $indicadorEstacionPrototype;
    }

    public function find($id_indicador, $id_estacion, $fecha)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('indicador_estacion');
        $select->where(array('id_indicador = ?' => $id_indicador,'id_estacion = ?' => $id_estacion,'fecha = ?' => $fecha));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->indicadorEstacionPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('indicador_estacion');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->indicadorEstacionPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(IndicadorEstacion $indicadorEstacionObject)
    {
        $indicadorEstacionData = $this->hydrator->extract($indicadorEstacionObject);
        $action = new Insert('indicador_estacion');
        $action->values($indicadorEstacionData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$indicadorEstacionObject->setId($newId);
        	}
        	return $indicadorEstacionObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(IndicadorEstacion $indicadorEstacionObject)
    {
        if($indicadorEstacionObject instanceof IndicadorEstacion){
        	$action = new Delete("indicador_estacion");
        	$action->where(array('id_indicador = ?' => $indicadorEstacionObject->getId_indicador(),'id_estacion = ?' => $indicadorEstacionObject->getId_estacion(),'fecha = ?' => $indicadorEstacionObject->getFecha()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

