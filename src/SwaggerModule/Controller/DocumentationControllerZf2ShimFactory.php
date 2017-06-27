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

namespace SwaggerModule\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DocumentationController factory
 *
 * @deprecated ZF2 BC, see \Zend\ServiceManager\FactoryInterface
 */
class DocumentationControllerZf2ShimFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // zf2 fallback, get real service locator
        if (get_class($serviceLocator) === 'Zend\Mvc\Controller\ControllerManager') {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $controller = new DocumentationController();
        /** @var $swagger \Swagger\Annotations\Swagger */
        $swagger = $serviceLocator->get('Swagger\Annotations\Swagger');
        $controller->setSwagger($swagger);
        return $controller;
    }
}
