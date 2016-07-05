<?php

namespace Mappers\Mapper\RolJerarquia;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Mappers\Model\RolJerarquia\RolJerarquia;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;

class ZendDbSqlMapper
{

    protected $dbAdapter = null;

    protected $hydrator = null;

    protected $rolJerarquiaPrototype = null;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, $rolJerarquiaPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->rolJerarquiaPrototype = $rolJerarquiaPrototype;
    }

    public function find($rol_id, $padre_id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('rol_jerarquia');
        $select->where(array('rol_id = ?' => $rol_id,'padre_id = ?' => $padre_id));
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
        	return $this->hydrator->hydrate($result->current(), $this->rolJerarquiaPrototype);
        }
        return null;
    }

    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select('rol_jerarquia');
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
        	$resultSet = new HydratingResultSet($this->hydrator, $this->rolJerarquiaPrototype);
        	return $resultSet->initialize($result);
        }
        return array();
    }

    public function insert(RolJerarquia $rolJerarquiaObject)
    {
        $rolJerarquiaData = $this->hydrator->extract($rolJerarquiaObject);
        $action = new Insert('rol_jerarquia');
        $action->values($rolJerarquiaData);
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
        	if ($newId = $result->getGeneratedValue()) {
        		$rolJerarquiaObject->setId($newId);
        	}
        	return $rolJerarquiaObject;
        }
        throw new \Exception("Database error");
    }

    public function delete(RolJerarquia $rolJerarquiaObject)
    {
        if($rolJerarquiaObject instanceof RolJerarquia){
        	$action = new Delete("rol_jerarquia");
        	$action->where(array('rol_id = ?' => $rolJerarquiaObject->getRol_id(),'padre_id = ?' => $rolJerarquiaObject->getPadre_id()));
        	$sql    = new Sql($this->dbAdapter);
        	$stmt   = $sql->prepareStatementForSqlObject($action);
        	$result = $stmt->execute();
        	return (bool)$result->getAffectedRows();
        }
    }


}

