<?php
/**
 * SwaggerModule
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright  Copyright (c) 2012 OuterEdge UK Ltd (http://www.outeredgeuk.com)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace SwaggerModule\Factory;

use Swagger\Swagger as SwaggerLibrary;
use Swagger\Resource;
use Swagger\Models;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\Code\Reflection\ClassReflection;

/**
 * SwaggerModule factory.
 */
class Swagger implements FactoryInterface
{
    
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
        $config = $serviceLocator->get('Configuration');
        
        if(!isset($config['swagger'])) {
            throw new \Exception('Configuration was not found');
        }
        
        $paths = $config['swagger']['paths'];
		if(count($paths) < 1) {
			throw new \Exception('No path(s) were specified');
		}

		$scanner = new DirectoryScanner($paths);
		$classList = array();
		foreach ($scanner->getClassNames() as $class) {
			$classReflection = new ClassReflection($class);
			array_push($classList, $classReflection);
		}		
		
		if(empty($classList)) {
			throw new \Exception('No classes found in specified path(s)');
		}

		$sw = new SwaggerLibrary();
		$sw->setClassList($classList)
		   ->setResources(new Resource($sw->getClassList()))
		   ->setModels(new Models($sw->getClassList()));

		return $sw;
	}
}