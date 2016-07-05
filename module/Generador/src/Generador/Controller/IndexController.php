<?php

namespace Generador\Controller;

use Zend\Code\Reflection\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Db\Metadata\Metadata;
use Zend\Debug\Debug;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $metadata = new Metadata($adapter);
        $tableNames = $metadata->getTableNames();
        $breadcrumb = array(
            array('titulo' => 'Administración', 'href' => '/'),
            array('titulo' => 'Generador models y mappers', 'href' => '#', 'activo' => true,)
        );
        $this->layout()->setVariable('breadcrumb', $breadcrumb);
        $result = new ViewModel();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $result->setTerminal(true);
        }
        $result->setVariables(array("tablas" => $tableNames));
        return $result;
    }

    public function procesarAction() {

        try {
            $rutaInicial = getcwd() . '/module/Mappers/';
            $ruta = getcwd() . '/module/Mappers/src/Mappers/';
            //Creación de estructura básica de mappers
            if (!file_exists($ruta . "Controller")) {
                mkdir($ruta . "Controller", 0755);
            }
            if (!file_exists($ruta . "Factory")) {
                mkdir($ruta . "Factory", 0755);
            }
            if (!file_exists($ruta . "Mapper")) {
                mkdir($ruta . "Mapper", 0755);
            }
            if (!file_exists($ruta . "Model")) {
                mkdir($ruta . "Model", 0755);
            }
            if (!file_exists($ruta . "Service")) {
                mkdir($ruta . "Service", 0755);
            }


            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $metadata = new Metadata($adapter);


            $tableNames = $metadata->getTableNames();

            $bodyConfig = "";

            foreach ($tableNames as $tabla) {

                $nombre = explode("_", $tabla);
                $nameTabla = "";
                if (count($nombre) > 1) {
                    foreach ($nombre as $n) {
                        $nameTabla .= ucfirst($n);
                    }
                } else {
                    $nameTabla = ucfirst($nombre[0]);
                }

                if (!file_exists($ruta . "Factory/" . $nameTabla)) {
                    mkdir($ruta . "Factory/" . $nameTabla);
                }
                if (!file_exists($ruta . "Mapper/" . $nameTabla)) {
                    mkdir($ruta . "Mapper/" . $nameTabla);
                }
                if (!file_exists($ruta . "Model/" . $nameTabla)) {
                    mkdir($ruta . "Model/" . $nameTabla);
                }
                if (!file_exists($ruta . "Service/" . $nameTabla)) {
                    mkdir($ruta . "Service/" . $nameTabla);
                }


                /**
                 * Creacion de mappers.
                 */
                /**
                 * Factory
                 * 1. SeriviceFactory
                 */
                $rutaFactory = $ruta . "Factory/" . $nameTabla . "/";
                $namespaceFactory = "Mappers\Factory\\" . $nameTabla;
                $nameFactory = $nameTabla . "ServiceFactory";

                $bodyFactory = 'return new ' . $nameTabla . 'Service($serviceLocator->get(\'Mappers\Mapper\\' . $nameTabla . '\ZendDbSqlMapper\'));';
                $file = new FileGenerator();

                $body = "class {$nameTabla}ServiceFactory implements FactoryInterface
	    		{
	    		public function createService(ServiceLocatorInterface \$serviceLocator)
	    		{
	    		return new {$nameTabla}Service(
	    		\$serviceLocator->get('Mappers\Mapper\\{$nameTabla}\ZendDbSqlMapper')
	    		);
	    	
	    	
	    	
	    	}
	    	}
	    	";
                $file->setBody($body);

                $file->setNamespace($namespaceFactory);

                $file->setUse('Mappers\Service\\' . $nameTabla . '\\' . $nameTabla . 'Service');
                $file->setUse('Zend\ServiceManager\FactoryInterface');
                $file->setUse('Zend\ServiceManager\ServiceLocatorInterface');

                $file->generate();

                file_put_contents($rutaFactory . $nameTabla . "ServiceFactory.php", $file->generate());

                /**
                 * 2. ZendDbSqlMapperFactory
                 */
                $archivo = "ZendDbSqlMapperFactory";
                $nameClass = "ZendDbSqlMapperFactory";


                $file = new FileGenerator();
                $file->setBody("
	    		class ZendDbSqlMapperFactory implements FactoryInterface
	    		{
	    	
	    		public function createService(ServiceLocatorInterface \$serviceLocator)
	    		{
	    		return new ZendDbSqlMapper(
	    		\$serviceLocator->get('Zend\Db\Adapter\Adapter'),
	    		new ClassMethods(false),
	    		new {$nameTabla}()
	    		);
	    	}
	    	}");

                $file->setNamespace($namespaceFactory);

                $file->setUse('Mappers\Mapper\\' . $nameTabla . '\ZendDbSqlMapper');
                $file->setUse('Mappers\Model\\' . $nameTabla . '\\' . $nameTabla . '');
                $file->setUse('Zend\ServiceManager\FactoryInterface');
                $file->setUse('Zend\ServiceManager\ServiceLocatorInterface');
                $file->setUse('Zend\Stdlib\Hydrator\ClassMethods');


                $file->generate();

                file_put_contents($rutaFactory . $archivo . ".php", $file->generate());


                /**
                 * Mapper
                 */
                /**
                 *
                 * 2. ZendDbSqlMapper
                 */
                $rutaMapper = $ruta . "Mapper/" . $nameTabla . "/";
                $archivo = "ZendDbSqlMapper.php";
                $method = new MethodGenerator();
                $method->setName("__construct")
                        ->setParameter("dbAdapter")
                        ->setParameter("hydrator")
                        ->setParameter(lcfirst($nameTabla) . "Prototype")
                        ->setBody('$this->dbAdapter = $dbAdapter;' .
                                "\n" . '$this->hydrator = $hydrator;' . "\n" .
                                '$this->' . lcfirst($nameTabla) . "Prototype" . ' = $' . lcfirst($nameTabla) . "Prototype" . ';' . "\n");


                $methodFind = new MethodGenerator();
                $methodFind->setName("find");
                $methodFind->setParameter("id");
                $methodFind->setBody(
                        '$sql    = new Sql($this->dbAdapter);' . "\n" .
                        '$select = $sql->select(\'' . $tabla . '\');' . "\n" .
                        '$select->where(array(\'id = ?\' => $id));' . "\n" .
                        '$stmt   = $sql->prepareStatementForSqlObject($select);' . "\n" .
                        '$result = $stmt->execute();' . "\n" .
                        'if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {' . "\n" .
                        '	return $this->hydrator->hydrate($result->current(), $this->' . lcfirst($nameTabla) . 'Prototype);' . "\n" .
                        '}' . "\n" .
                        'throw new \InvalidArgumentException("' . $nameTabla . ' con ID:{$id} no encontrada.");' . "\n");

                $methodFindAll = new MethodGenerator();
                $methodFindAll->setName("findAll");
                $methodFindAll->setBody(
                        '$sql    = new Sql($this->dbAdapter);
	    									$select = $sql->select(\'' . $tabla . '\');
	    	
	    									$stmt   = $sql->prepareStatementForSqlObject($select);
	    											$result = $stmt->execute();
	    	
	    											if ($result instanceof ResultInterface && $result->isQueryResult()) {
	    											$resultSet = new HydratingResultSet($this->hydrator, $this->' . lcfirst($nameTabla) . 'Prototype);
	    	
	    											return $resultSet->initialize($result);
	    	}
	    	
	    	return array();'
                );

                $methodInsert = new MethodGenerator();
                $methodInsert->setName("insert");
                $methodInsert->setParameter(lcfirst($nameTabla) . "Object");
                $methodInsert->setBody(
                        "\$" . lcfirst($nameTabla) . "Data = \$this->hydrator->extract(\$" . lcfirst($nameTabla) . "Object);
        
\$action = new Insert('" . $tabla . "');
\$action->values(\$" . lcfirst($nameTabla) . "Data);
        
\$sql    = new Sql(\$this->dbAdapter);
\$stmt   = \$sql->prepareStatementForSqlObject(\$action);
\$result = \$stmt->execute();
if (\$result instanceof ResultInterface) {
   if (\$newId = \$result->getGeneratedValue()) {
      // When a value has been generated, set it on the object
     \$" . lcfirst($nameTabla) . "Object->setId(\$newId);
   }
   return \$" . lcfirst($nameTabla) . "Object;
}
throw new \Exception(\"Database error\");"
                );
                $methodDelete = new MethodGenerator();
                $methodDelete->setName("delete");
                $methodDelete->setParameter(lcfirst($nameTabla) . "Object");
                $methodDelete->setBody(
                        'if($' . lcfirst($nameTabla) . 'Object instanceof ' . ucfirst($nameTabla) . '){
            $action = new Delete("' . $tabla . '");
            $action->where(array("id = ?" => $' . lcfirst($nameTabla) . 'Object->getId()));

            $sql    = new Sql($this->dbAdapter);
            $stmt   = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();

            return (bool)$result->getAffectedRows();
         }'
                );

                $methodUpdate = new MethodGenerator();
                $class = new ClassGenerator();
                $class->setName("ZendDbSqlMapper");
                $class->addProperty("dbAdapter", null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty("hydrator", null, PropertyGenerator::FLAG_PROTECTED);
                $class->addProperty(lcfirst($nameTabla) . "Prototype", null, PropertyGenerator::FLAG_PROTECTED);
                $class->addMethodFromGenerator($method);
                $class->addMethodFromGenerator($methodFind);
                $class->addMethodFromGenerator($methodFindAll);
                $class->addMethodFromGenerator($methodInsert);
                $class->addMethodFromGenerator($methodDelete);
                $class->setNamespaceName("Mappers\Mapper\\" . $nameTabla);

                $class->addUse("Zend\Stdlib\Hydrator\HydratorInterface");
                $class->addUse("Zend\Db\ResultSet\HydratingResultSet");
                $class->addUse("Zend\Db\Adapter\Driver\ResultInterface");
                //     		$class->addUse("Mappers\Mapper\\".$nameTabla."\\".$nameTabla."Mapper");
                $class->addUse("Mappers\Model\\" . $nameTabla . "\\" . $nameTabla . "");
                $class->addUse("Zend\Db\Adapter\AdapterInterface");
                $class->addUse("Zend\Db\Sql\Sql");
                $class->addUse("Zend\Db\Sql\Insert");

                $file = new FileGenerator();
                $file->setClass($class);
                $file->generate();




                file_put_contents($rutaMapper . $archivo, $file->generate());


                /**
                 * Model
                 */
                $rutaModel = $ruta . "Model/" . $nameTabla . "/";
                $archivo = $nameTabla . ".php";
                $class = new ClassGenerator();
                $class->setName($nameTabla);

                foreach ($metadata->getColumns($tabla) as $column) {

                    $class->addProperty($column->getName(), null, PropertyGenerator::FLAG_PROTECTED);
                }

                foreach ($metadata->getColumns($tabla) as $column) {
                    $nameColumna = ucfirst($column->getName());
                    $tipo = $column->getDataType();
                    $entero = array('int', 'mediumint');
                    $string = array('varchar');
                    $dateTime = array('datetime');
                    $tipoDato = "desconocido";
                    if (in_array($tipo, $entero)) {
                        $tipoDato = "int";
                    }
                    if (in_array($tipo, $string)) {
                        $tipoDato = "string";
                    }
                    if (in_array($tipo, $dateTime)) {
                        $tipoDato = "Zend/Date";
                    }

                    // Metodo Set
                    $paramTag = new ParamTag();
                    $paramTag->setDatatype($tipoDato);
                    $paramTag->setParamName($column->getName());
                    $setDoc = new DocBlockGenerator();
                    $setDoc->setTags(array($paramTag
                    ));
                    $setDoc->setShortDescription("Setea el parametro " . $column->getName());
                    $methodSet = new MethodGenerator();
                    $methodSet->setName("set" . $nameColumna);
                    $methodSet->setDocBlock($setDoc);
                    $methodSet->setParameter($column->getName());
                    $methodSet->setBody('$this->' . $column->getName() . ' = $' . $column->getName() . ';');

                    $class->addMethodFromGenerator($methodSet);
                    // metodo Get

                    $setDoc = new DocBlockGenerator();
                    $setDoc->setTags(array(new Tag\ReturnTag(array(
                            'datatype' => 'string',
                                )),));
                    $setDoc->setShortDescription("Retorna el parametro " . $column->getName());
                    $methodGet = new MethodGenerator();
                    $methodGet->setName("get" . $nameColumna);
                    $methodGet->setBody('return $this->' . $column->getName() . ';');
                    $methodGet->setDocBlock($setDoc);
                    $class->addMethodFromGenerator($methodGet);
                }

                $file = new FileGenerator();
                $file->setClass($class);
                $file->setNamespace("Mappers\Model\\" . $nameTabla);
                $file->setUse("Mappers\Model\\" . $nameTabla . "\\" . $nameTabla . "");


                $file->generate();




                file_put_contents($rutaModel . $archivo, $file->generate());

                /**
                 * Service
                 */
                $rutaService = $ruta . "Service/" . $nameTabla . "/";
                $archivo = $nameTabla . "Service.php";

                $class = new ClassGenerator();
                $class->setName($nameTabla . "Service");
                $class->addProperty(lcfirst($nameTabla) . "Mapper", null, PropertyGenerator::FLAG_PROTECTED);
                //     		$class->setImplementedInterfaces(array("BodegaServiceInterface"));
                $method = new MethodGenerator();
                $method->setName("__construct")
                        ->setParameter(lcfirst($nameTabla) . "Mapper")
                        ->setBody('$this->' . lcfirst($nameTabla) . 'Mapper = $' . lcfirst($nameTabla) . 'Mapper;');


                $methodFind = new MethodGenerator();
                $methodFind->setName("find");
                $methodFind->setParameter("id");
                $methodFind->setBody(
                        'return $this->' . lcfirst($nameTabla) . 'Mapper->find($id);');

                $methodFindAll = new MethodGenerator();
                $methodFindAll->setName("findAll");
                $methodFindAll->setBody(
                        'return $this->' . lcfirst($nameTabla) . 'Mapper->findAll();'
                );

                $methodInsert = new MethodGenerator();
                $methodInsert->setName("insert");
                $methodInsert->setParameter($nameTabla . "Object");
                $methodInsert->setBody(
                        "return \$this->" . lcfirst($nameTabla) . "Mapper->insert($" . $nameTabla . "Object);"
                );

                $methodDelete = new MethodGenerator();
                $methodDelete->setName("delete");
                $methodDelete->setParameter($nameTabla . "Object");
                $methodDelete->setBody(
                        "return \$this->" . lcfirst($nameTabla) . "Mapper->delete($" . $nameTabla . "Object);"
                );


                $class->addMethodFromGenerator($method);
                $class->addMethodFromGenerator($methodFind);
                $class->addMethodFromGenerator($methodFindAll);
                $class->addMethodFromGenerator($methodInsert);
                $class->addMethodFromGenerator($methodDelete);







                $file = new FileGenerator();
                $file->setClass($class);
                $file->setNamespace("Mappers\Service\\" . $nameTabla);
                $file->setUse("Mappers\Mapper\\" . $nameTabla . "\ZendDbSqlMapper");
                $file->generate();


                file_put_contents($rutaService . $archivo, $file->generate());

                /**
                 * Module Config
                 */
                $bodyConfig .= " // Tabla " . $nameTabla . " \n\t\t\t";
                $bodyConfig .= "'Mappers\Mapper\\" . $nameTabla . "\ZendDbSqlMapper'\t\t=> \t\t'Mappers\Factory\\" . $nameTabla . "\ZendDbSqlMapperFactory',\n\t\t\t";
                $bodyConfig .= "'Mappers\Service\\" . $nameTabla . "\\" . $nameTabla . "Service' => 'Mappers\Factory\\" . $nameTabla . "\\" . $nameTabla . "ServiceFactory',\n\t\t\t";



                foreach ($metadata->getConstraints($tabla) as $constraint) {
                    //     			Debug::dump($constraint->getName());
                    //     			Debug::dump($constraint->getType());
                    //     			if (!$constraint->hasColumns()) {
                    //     				continue;
                    //     			}
                    //     			echo '            column: ' . implode(', ', $constraint->getColumns());
                    //     			if ($constraint->isForeignKey()) {
                    //     				$fkCols = array();
                    //     				foreach ($constraint->getReferencedColumns() as $refColumn) {
                    //     					$fkCols[] = $constraint->getReferencedTableName() . '.' . $refColumn;
                    //     				}
                    //     				echo ' => ' . implode(', ', $fkCols);
                    //     			}
                    //     			echo PHP_EOL;
                }
            }
            $file = new FileGenerator();
            $rutaConfig = $rutaInicial . "config/";
            $archivo = "module.config.php";
            $file->setBody(
                    "<?php \nreturn array( \n'service_manager' => array( \n 'factories' => array(\n\t\t\t" .
                    $bodyConfig . "\n" .
                    "// Adaptador
	    	'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory'\n" .
                    "\t\t)\n\t)\n);");


            file_put_contents($rutaConfig . $archivo, $file->generate());
        } catch (Exception $e) {
            echo "Error al cargar Mappers";
        }
        $result = new ViewModel();
        $result->setTerminal(true);
//     	$result->setVariables(array('items' => 'items'));
        return $result;

//     	return new ViewModel();
    }

    /**

     */
    public function procesarFiltradoAction() {
        $filtroTabla = $this->params()->fromPost('tabla');


        try {


            $rutaInicial = getcwd() . '/module/Mappers/';
            $ruta = getcwd() . '/module/Mappers/src/Mappers/';
            //Creación de estructura básica de mappers
            if (!file_exists($ruta . "Controller")) {
                mkdir($ruta . "Controller", 0755, true);
            }
            if (!file_exists($ruta . "Factory")) {
                mkdir($ruta . "Factory", 0755);
            }
            if (!file_exists($ruta . "Mapper")) {
                mkdir($ruta . "Mapper", 0755);
            }
            if (!file_exists($ruta . "Model")) {
                mkdir($ruta . "Model", 0755);
            }
            if (!file_exists($ruta . "Service")) {
                mkdir($ruta . "Service", 0755);
            }


            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $metadata = new Metadata($adapter);
            

            $tableNames = $metadata->getTableNames();

            $bodyConfig = "";

            foreach ($tableNames as $tabla) {
                if ($tabla == $filtroTabla) {
                    
                    $claves = array();
                    $claves["primarias"] = array();
                    $claves["foraneas"] = array();
                    foreach ($metadata->getConstraints($tabla) as $constraint) {

                        if ( $constraint instanceof \Zend\Db\Metadata\Object\ConstraintObject){
                            if($constraint->getType() == "PRIMARY KEY"){

                                $claves["primarias"]["columnas"] = $constraint->getColumns();

                            }
                            if($constraint->getType() == "FOREIGN KEY"){

                                $clave = array();
                                $clave["tablaReferenciada"]     = $constraint->getReferencedTableName();
                                $clave["columnas"]  = $constraint->getColumns();
                                $clave["columnasReferenciadas"]  = $constraint->getReferencedColumns();
                                array_push($claves["foraneas"], $clave);
                            }

                        }


                    }


                    $nombre = explode("_", $tabla);
                    $nameTabla = "";
                    if (count($nombre) > 1) {
                        foreach ($nombre as $n) {
                            $nameTabla .= ucfirst($n);
                        }
                    } else {
                        $nameTabla = ucfirst($nombre[0]);
                    }

                    if (!file_exists($ruta . "Factory/" . $nameTabla)) {
                        mkdir($ruta . "Factory/" . $nameTabla);
                    }
                    if (!file_exists($ruta . "Mapper/" . $nameTabla)) {
                        mkdir($ruta . "Mapper/" . $nameTabla);
                    }
                    if (!file_exists($ruta . "Model/" . $nameTabla)) {
                        mkdir($ruta . "Model/" . $nameTabla);
                    }
                    if (!file_exists($ruta . "Service/" . $nameTabla)) {
                        mkdir($ruta . "Service/" . $nameTabla);
                    }
                    // Factorias
                    // Crea claseFactory
                    $rutaFactory = $ruta . "Factory/" . $nameTabla . "/";
                    $namespaceFactory = "Mappers\Factory\\" . $nameTabla;
                    $nameFactory = $nameTabla . "ServiceFactory";

                    $this->createFactory($rutaFactory, $namespaceFactory, $nameFactory, $nameTabla);

                    // Crea ZendDbSqlMapperFactory
                    $archivo = "ZendDbSqlMapperFactory";
                    $nameClass = "ZendDbSqlMapperFactory";

                    $this->createZendDbSqlMapperFactory($rutaFactory, $namespaceFactory, $nameTabla, $archivo, $nameClass);

                    //Mappers
                    // Crea ZendDbSqlMapper
                    $rutaMapper = $ruta . "Mapper/" . $nameTabla . "/";
                    $archivo = "ZendDbSqlMapper.php";
                    $this->createZendDbSqlMapper($rutaMapper, $archivo, $nameTabla,$tabla,$claves);



                    /**
                     * Model
                     */
                    $rutaModel = $ruta . "Model/" . $nameTabla . "/";
                    $archivo = $nameTabla . ".php";


                    $this->createModel($rutaModel, $archivo, $nameTabla, $metadata, $tabla);
                    


                    /**
                     * Service
                     */
                    $rutaService = $ruta . "Service/" . $nameTabla . "/";
                    $archivo = $nameTabla . "Service.php";

                    $class = new ClassGenerator();
                    $class->setName($nameTabla . "Service");
                    $class->addProperty(lcfirst($nameTabla) . "Mapper", null, PropertyGenerator::FLAG_PROTECTED);
                    //     		$class->setImplementedInterfaces(array("BodegaServiceInterface"));
                    $method = new MethodGenerator();
                    $method->setName("__construct")
                            ->setParameter(lcfirst($nameTabla) . "Mapper")
                            ->setBody('$this->' . lcfirst($nameTabla) . 'Mapper = $' . lcfirst($nameTabla) . 'Mapper;');

                    $methodFind = new MethodGenerator();
                    $methodFind->setName("find");
                    foreach($claves["primarias"]["columnas"] as $col){
                        $methodFind->setParameter($col);
                    }
                    $arrayClaves = array();
                    foreach($claves["primarias"]["columnas"] as $col){
                        $arrayClaves[] = '$'.$col;
                    }
                    $methodFind->setBody('return $this->' . lcfirst($nameTabla) . 'Mapper->find('.  implode(",", $arrayClaves).');');

                    $methodFindAll = new MethodGenerator();
                    $methodFindAll->setName("findAll");
                    
                    $methodFindAll->setBody('return $this->' . lcfirst($nameTabla) . 'Mapper->findAll();');

                    $methodInsert = new MethodGenerator();
                    $methodInsert->setName("insert");
                    $methodInsert->setParameter($nameTabla . "Object");
                    $methodInsert->setBody("return \$this->" . lcfirst($nameTabla) . "Mapper->insert($" . $nameTabla . "Object);");

                    $methodDelete = new MethodGenerator();
                    $methodDelete->setName("delete");
                    $methodDelete->setParameter($nameTabla . "Object");
                    $methodDelete->setBody(
                            "return \$this->" . lcfirst($nameTabla) . "Mapper->delete($" . $nameTabla . "Object);"
                    );

                    $class->addMethodFromGenerator($method);
                    $class->addMethodFromGenerator($methodFind);
                    $class->addMethodFromGenerator($methodFindAll);
                    $class->addMethodFromGenerator($methodInsert);
                    $class->addMethodFromGenerator($methodDelete);


                    $file = new FileGenerator();
                    $file->setClass($class);
                    $file->setNamespace("Mappers\Service\\" . $nameTabla);
                    $file->setUse("Mappers\Mapper\\" . $nameTabla . "\ZendDbSqlMapper");
                    $file->generate();

                    file_put_contents($rutaService . $archivo, $file->generate());

                    /**
                     * Module Config
                     */
                    $bodyConfig .= " // Tabla " . $nameTabla . " \n\t\t\t";
                    $bodyConfig .= "'Mappers\Mapper\\" . $nameTabla . "\ZendDbSqlMapper'\t\t=> \t\t'Mappers\Factory\\" . $nameTabla . "\ZendDbSqlMapperFactory',\n\t\t\t";
                    $bodyConfig .= "'Mappers\Service\\" . $nameTabla . "\\" . $nameTabla . "Service' => 'Mappers\Factory\\" . $nameTabla . "\\" . $nameTabla . "ServiceFactory',\n\t\t\t";


                    foreach ($metadata->getConstraints($tabla) as $constraint) {
                        //     			Debug::dump($constraint->getName());
                        //     			Debug::dump($constraint->getType());
                        //     			if (!$constraint->hasColumns()) {
                        //     				continue;
                        //     			}
                        //     			echo '            column: ' . implode(', ', $constraint->getColumns());
                        //     			if ($constraint->isForeignKey()) {
                        //     				$fkCols = array();
                        //     				foreach ($constraint->getReferencedColumns() as $refColumn) {
                        //     					$fkCols[] = $constraint->getReferencedTableName() . '.' . $refColumn;
                        //     				}
                        //     				echo ' => ' . implode(', ', $fkCols);
                        //     			}
                        //     			echo PHP_EOL;
                    }
                }
            }
            $file = new FileGenerator();
            $rutaConfig = $rutaInicial . "config/";
            $archivo = "module.config.php";
            $file->setBody(
                    "<?php \nreturn array( \n'service_manager' => array( \n 'factories' => array(\n\t\t\t" .
                    $bodyConfig . "\n" .
                    "// Adaptador
    				'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory'\n" .
                    "\t\t)\n\t)\n);");


            file_put_contents($rutaConfig . $archivo, $file->generate());
        } catch (Exception $e) {
            echo "Error al cargar Mappers";
        }
        $result = new ViewModel();
        $result->setTerminal(true);
        //     	$result->setVariables(array('items' => 'items'));
        return $result;

        //     	return new ViewModel();
    }

    public function eliminaFiltradoAction() {
        $filtroTabla = $this->params()->fromPost('tabla');
        $ruta = getcwd() . '/module/Mappers/src/Mappers/';
        $nombre = explode("_", $filtroTabla);
        $nameTabla = "";
        if (count($nombre) > 1) {
            foreach ($nombre as $n) {
                $nameTabla .= ucfirst($n);
            }
        } else {
            $nameTabla = ucfirst($nombre[0]);
        }


        if (file_exists($ruta . "Factory/" . $nameTabla)) {

            $this->eliminaDirRecursivo($ruta . "Factory/" . $nameTabla);
        }
        if (file_exists($ruta . "Mapper/" . $nameTabla)) {
            $this->eliminaDirRecursivo($ruta . "Mapper/" . $nameTabla);
        }
        if (file_exists($ruta . "Model/" . $nameTabla)) {
            $this->eliminaDirRecursivo($ruta . "Model/" . $nameTabla);
        }
        if (file_exists($ruta . "Service/" . $nameTabla)) {
            $this->eliminaDirRecursivo($ruta . "Service/" . $nameTabla);
        }

        $result = new ViewModel();
        $result->setTerminal(true);
        //     	$result->setVariables(array('items' => 'items'));
        return $result;
    }

    public function eliminaDirRecursivo($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->eliminaDirRecursivo($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    private function createModel($rutaModel, $archivo, $nameTabla, $metadata, $tabla) {

        $class = new ClassGenerator();
        $class->setName($nameTabla);
        
        $entero = array('int', 'mediumint');
        $string = array('varchar');
        $dateTime = array('datetime');
        
       
        foreach ($metadata->getColumns($tabla) as $column) {
            
             
            $tipo = $column->getDataType();
            
           
            if (in_array($tipo, $string)) {
                $tipoDato = "";
            }else{
                $tipoDato = null;
            }
           
            
            $class->addProperty($column->getName(), $tipoDato, PropertyGenerator::FLAG_PROTECTED);
        }

        foreach ($metadata->getColumns($tabla) as $column) {
            $nameColumna = ucfirst($column->getName());
            $tipo = $column->getDataType();
            
            if (in_array($tipo, $entero)) {
                $tipoDato = "int";
            }
            if (in_array($tipo, $string)) {
                $tipoDato = "string";
            }
            if (in_array($tipo, $dateTime)) {
                $tipoDato = "Zend/Date";
            }

            // Metodo Set
            $paramTag = new ParamTag();
            $paramTag->setDatatype($tipoDato);
            $paramTag->setParamName($column->getName());
            $setDoc = new DocBlockGenerator();
            $setDoc->setTags(array($paramTag
            ));
            $setDoc->setShortDescription("Setea el parametro " . $column->getName());
            $methodSet = new MethodGenerator();
            $methodSet->setName("set" . $nameColumna);
            $methodSet->setDocBlock($setDoc);
            $methodSet->setParameter($column->getName());
            $methodSet->setBody('$this->' . $column->getName() . ' = $' . $column->getName() . ';');

            $class->addMethodFromGenerator($methodSet);
            // metodo Get

            $setDoc = new DocBlockGenerator();
            $setDoc->setTags(array(new Tag\ReturnTag(array(
                    'datatype' => 'string',
                        )),));
            $setDoc->setShortDescription("Retorna el parametro " . $column->getName());
            $methodGet = new MethodGenerator();
            $methodGet->setName("get" . $nameColumna);
            $methodGet->setBody('return $this->' . $column->getName() . ';');
            $methodGet->setDocBlock($setDoc);
            $class->addMethodFromGenerator($methodGet);
        }

        $file = new FileGenerator();
        $file->setClass($class);
        $file->setNamespace("Mappers\Model\\" . $nameTabla);
        $file->setUse("Mappers\Model\\" . $nameTabla . "\\" . $nameTabla . "");


        $file->generate();




        file_put_contents($rutaModel . $archivo, $file->generate());
    }

    private function createZendDbSqlMapper($rutaMapper, $archivo, $nameTabla,$tabla,$claves) {
        $arrayPrimary = array();
        foreach($claves["primarias"]["columnas"] as $col){
            $arrayPrimary[] = "$".$col;
        }
        $primaryString = implode(",", $arrayPrimary);
        
                
        
        $paramDbAdapter = new \Zend\Code\Generator\ParameterGenerator();
        $paramDbAdapter->setName("dbAdapter");
        $paramDbAdapter->setReferencia("AdapterInterface");

        $paramHydrator = new \Zend\Code\Generator\ParameterGenerator();
        $paramHydrator->setName("hydrator");
        $paramHydrator->setReferencia("HydratorInterface");

        $paramPrototype = new \Zend\Code\Generator\ParameterGenerator();
        $paramPrototype->setName(lcfirst($nameTabla) . "Prototype");



        $method = new MethodGenerator();
        $method->setName("__construct")
                ->setParameter($paramDbAdapter)
                ->setParameter($paramHydrator)
                ->setParameter($paramPrototype)
                ->setBody('$this->dbAdapter = $dbAdapter;' .
                        "\n" . '$this->hydrator = $hydrator;' . "\n" .
                        '$this->' . lcfirst($nameTabla) . "Prototype" . ' = $' . lcfirst($nameTabla) . "Prototype" . ';' . "\n");

        ##### FIND METHOD ########
        $methodFind = new MethodGenerator();
        $methodFind->setName("find");
        $whereSelect = array();
        $exceptionSelect = array();
        foreach($claves["primarias"]["columnas"] as $col){
            $methodFind->setParameter($col);
            $whereSelect[] = "'$col = ?' => \$$col";
            $exceptionSelect[] = $col.':{$'.$col.'}';
        }
        $methodFind->setBody(
                '$sql    = new Sql($this->dbAdapter);' . "\n" .
                '$select = $sql->select(\'' . $tabla . '\');' . "\n" .
                "\$select->where(array(".implode(",", $whereSelect)."));" . "\n" .
                '$stmt   = $sql->prepareStatementForSqlObject($select);' . "\n" .
                '$result = $stmt->execute();' . "\n" .
                'if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {' . "\n" .
                '	return $this->hydrator->hydrate($result->current(), $this->' . lcfirst($nameTabla) . 'Prototype);' . "\n" .
                '}' . "\n" .
                'return null;' . "\n");

        $methodFindAll = new MethodGenerator();
        $methodFindAll->setName("findAll");
        $methodFindAll->setBody(
                '$sql    = new Sql($this->dbAdapter);' . "\n" .
                '$select = $sql->select(\'' . $tabla . '\');' . "\n" .
                '$stmt   = $sql->prepareStatementForSqlObject($select);' . "\n" .
                '$result = $stmt->execute();' . "\n" .
                'if ($result instanceof ResultInterface && $result->isQueryResult()) {' . "\n" .
                "\t" . '$resultSet = new HydratingResultSet($this->hydrator, $this->' . lcfirst($nameTabla) . 'Prototype);' . "\n" .
                "\t" . 'return $resultSet->initialize($result);' . "\n" .
                '}' . "\n" .
                'return array();'
        );
        
        $paramObject = new \Zend\Code\Generator\ParameterGenerator();
        $paramObject->setName(lcfirst($nameTabla) . "Object");
        $paramObject->setReferencia($nameTabla);
        
        ###### INSERT METHOD ######
        
        $methodInsert = new MethodGenerator();
        $methodInsert->setName("insert");
        $methodInsert->setParameter($paramObject);
        $methodInsert->setBody(
                "\$" . lcfirst($nameTabla) . "Data = \$this->hydrator->extract(\$" . lcfirst($nameTabla) . "Object);" . "\n" .
                "\$action = new Insert('" . $tabla . "');" . "\n" .
                "\$action->values(\$" . lcfirst($nameTabla) . "Data);" . "\n" .
                "\$sql    = new Sql(\$this->dbAdapter);" . "\n" .
                "\$stmt   = \$sql->prepareStatementForSqlObject(\$action);" . "\n" .
                "\$result = \$stmt->execute();" . "\n" .
                "if (\$result instanceof ResultInterface) {" . "\n" .
                "\t" . "if (\$newId = \$result->getGeneratedValue()) {" . "\n" .
                "\t" . "\t" . "\$" . lcfirst($nameTabla) . "Object->setId(\$newId);" . "\n" .
                "\t" . "}" . "\n" .
                "\t" . "return \$" . lcfirst($nameTabla) . "Object;" . "\n" .
                "}" . "\n" .
                "throw new \Exception(\"Database error\");"
        );
        
        ### DELETE METHOD #####
        $whereDelete = array();
        $exceptionSelect = array();
        foreach($claves["primarias"]["columnas"] as $col){
            $methodFind->setParameter($col);
            $whereDelete[] = "'$col = ?' => \$". lcfirst($nameTabla) . 'Object->get'. ucfirst($col) .'()';
            $exceptionSelect[] = $col.':{$'.$col.'}';
        }
        $methodDelete = new MethodGenerator();
        $methodDelete->setName("delete");
        $methodDelete->setParameter($paramObject);
        $methodDelete->setBody(
                'if($' . lcfirst($nameTabla) . 'Object instanceof ' . ucfirst($nameTabla) . '){' . "\n" .
                "\t" . '$action = new Delete("' . $tabla . '");' . "\n" .
                "\t" . '$action->where(array('.  implode(",", $whereDelete).'));' . "\n" .
                "\t" . '$sql    = new Sql($this->dbAdapter);' . "\n" .
                "\t" . '$stmt   = $sql->prepareStatementForSqlObject($action);' . "\n" .
                "\t" . '$result = $stmt->execute();' . "\n" .
                "\t" . 'return (bool)$result->getAffectedRows();' . "\n" .
                '}'
        );

        $methodUpdate = new MethodGenerator();
        $class = new ClassGenerator();
        $class->setName("ZendDbSqlMapper");
        $class->addProperty("dbAdapter", null, PropertyGenerator::FLAG_PROTECTED);
        $class->addProperty("hydrator", null, PropertyGenerator::FLAG_PROTECTED);
        $class->addProperty(lcfirst($nameTabla) . "Prototype", null, PropertyGenerator::FLAG_PROTECTED);
        $class->addMethodFromGenerator($method);
        $class->addMethodFromGenerator($methodFind);
        $class->addMethodFromGenerator($methodFindAll);
        $class->addMethodFromGenerator($methodInsert);
        $class->addMethodFromGenerator($methodDelete);

        $class->setNamespaceName("Mappers\Mapper\\" . $nameTabla);

        $class->addUse("Zend\Stdlib\Hydrator\HydratorInterface");
        $class->addUse("Zend\Db\ResultSet\HydratingResultSet");
        $class->addUse("Zend\Db\Adapter\Driver\ResultInterface");
        //     		$class->addUse("Mappers\Mapper\\".$nameTabla."\\".$nameTabla."Mapper");
        $class->addUse("Mappers\Model\\" . $nameTabla . "\\" . $nameTabla . "");
        $class->addUse("Zend\Db\Adapter\AdapterInterface");
        $class->addUse("Zend\Db\Sql\Sql");
        $class->addUse("Zend\Db\Sql\Insert");
        $class->addUse("Zend\Db\Sql\Delete");

        $file = new FileGenerator();
        $file->setClass($class);
        $file->generate();




        file_put_contents($rutaMapper . $archivo, $file->generate());
    }

    private function createZendDbSqlMapperFactory($rutaFactory, $namespaceFactory, $nameTabla, $archivo, $nameClass) {

        $file = new FileGenerator();
        $clase = new ClassGenerator();
        $docblock = DocBlockGenerator::fromArray(array(
                    'shortDescription' => 'Clase ZendDbSqlMapperFactory  ' . $nameTabla,
                    'longDescription' => 'This is a class generated with Zend\Code\Generator.',
                    'tags' => array(
                        array(
                            'name' => 'version',
                            'description' => '1.0',
                        ),
                        array(
                            'name' => 'license',
                            'description' => 'Creado por cristian nores para ipservice.cl',
                        ),
                    ),
        ));
        $parametros = new \Zend\Code\Generator\ParameterGenerator();
        $parametros->setName("serviceLocator");
        $parametros->setReferencia("ServiceLocatorInterface");
        $returnTag = new Tag\ReturnTag();
        $returnTag->setTypes("string");
        $bodyMethod = "return new ZendDbSqlMapper("
                . "\$serviceLocator->get('Zend\Db\Adapter\Adapter'),new ClassMethods(false),new {$nameTabla}());";
        $method = new MethodGenerator(
                'createService', array($parametros), MethodGenerator::FLAG_PUBLIC, $bodyMethod, null
        );
        $clase->setName("ZendDbSqlMapperFactory")
                ->setDocblock($docblock)
                ->setImplementedInterfaces(array("name" => "FactoryInterface"))
                ->addMethodFromGenerator($method);
        $file->setBody($clase->generate());

        $file->setNamespace($namespaceFactory);

        $file->setUse('Mappers\Mapper\\' . $nameTabla . '\ZendDbSqlMapper');
        $file->setUse('Mappers\Model\\' . $nameTabla . '\\' . $nameTabla . '');
        $file->setUse('Zend\ServiceManager\FactoryInterface');
        $file->setUse('Zend\ServiceManager\ServiceLocatorInterface');
        $file->setUse('Zend\Stdlib\Hydrator\ClassMethods');


        $file->generate();

        file_put_contents($rutaFactory . $archivo . ".php", $file->generate());
    }

    private function createFactory($rutaFactory, $namespaceFactory, $nameFactory, $nameTabla) {

        $file = new FileGenerator();

        $claseFactory = new ClassGenerator();
        $docblock = DocBlockGenerator::fromArray(array(
                    'shortDescription' => 'Clase factory ' . $nameTabla,
                    'longDescription' => 'This is a class generated with Zend\Code\Generator.',
                    'tags' => array(
                        array(
                            'name' => 'version',
                            'description' => '1.0',
                        ),
                        array(
                            'name' => 'license',
                            'description' => 'Creado por cristian nores para ipservice.cl',
                        ),
                    ),
        ));
        $parametros = new \Zend\Code\Generator\ParameterGenerator();
        $parametros->setName("serviceLocator");
        $parametros->setReferencia("ServiceLocatorInterface");
        $returnTag = new Tag\ReturnTag();
        $returnTag->setTypes("string");
        $bodyMethod = "return new {$nameTabla}Service("
                . "\$serviceLocator->get('Mappers\Mapper\\{$nameTabla}\ZendDbSqlMapper'));";
        $method = new MethodGenerator(
                'createService', array($parametros), MethodGenerator::FLAG_PUBLIC, $bodyMethod, null
        );
        $claseFactory->setName("{$nameTabla}ServiceFactory")
                ->setDocblock($docblock)
                ->setImplementedInterfaces(array("name" => "FactoryInterface"))
                ->addMethodFromGenerator($method);

        $file->setBody($claseFactory->generate());
        $file->setNamespace($namespaceFactory);

        $file->setUse('Mappers\Service\\' . $nameTabla . '\\' . $nameTabla . 'Service');
        $file->setUse('Zend\ServiceManager\FactoryInterface');
        $file->setUse('Zend\ServiceManager\ServiceLocatorInterface');

        $file->generate();

        file_put_contents($rutaFactory . $nameTabla . "ServiceFactory.php", $file->generate());
    }

}
