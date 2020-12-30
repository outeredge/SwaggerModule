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

use Swagger\Annotations\Swagger;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

/**
 * DocumentationController. It is used to display a documentation in HTML
 */
class DocumentationController extends AbstractActionController
{
    protected $swagger;

    public function setSwagger(Swagger $swagger) {
        $this->swagger = $swagger;
    }

    /**
     * Display the documentation
     *
     * @return JsonModel
     */
    public function displayAction()
    {
        $jsonModel = new JsonModel((array)$this->swagger->jsonSerialize());
        return $jsonModel;
    }

    /**
     * Get the details of a resource
     *
     * @return JsonModel
     */
    public function detailsAction()
    {
        /** @var $options \SwaggerModule\Options\ModuleOptions */
        $options = $this->serviceLocator->get('SwaggerModule\Options\ModuleOptions');
        $resourceOptions = $options->getResourceOptions() ? : array();
        $resource = $this->swagger->getResource('/' . $this->params('resource', null), $resourceOptions);

        if ($resource === false) {
            return new JsonModel();
        }

        $jsonModel = new JsonModel();

        return $jsonModel->setVariables($resource);
    }
}
