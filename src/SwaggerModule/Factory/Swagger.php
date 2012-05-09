<?php

namespace SwaggerModule\Factory;

use Swagger\Swagger as SwaggerLibrary,	
	Swagger\Resource,
	Swagger\Models,
	Zend\Code\Scanner\DirectoryScanner,
	Zend\Code\Reflection\ClassReflection;

/**
 * SwaggerModule factory.
 */
class Swagger
{
	public static function get($path)
	{
		if(!$path) {
			throw new \Exception('No path was specified');
		}

		$scanner = new DirectoryScanner($path);
		$classList = array();		
		foreach ($scanner->getClassNames() as $class) {
			$classReflection = new ClassReflection($class);
			array_push($classList, $classReflection);
		}		
		
		if(empty($classList)) {
			throw new \Exception('No classes found in specified path');
		}

		$sw = new SwaggerLibrary();
		$sw->setClassList($classList)
		   ->setResources(new Resource($sw->getClassList()))
		   ->setModels(new Models($sw->getClassList()));

		return $sw;
	}
}