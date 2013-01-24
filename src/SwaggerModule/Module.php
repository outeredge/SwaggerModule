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

namespace SwaggerModule;

use RuntimeException;
use Swagger\Swagger as SwaggerLibrary;
use SwaggerModule\Options\ModuleOptions as SwaggerModuleOptions;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * SwaggerModule
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'service.swagger' => 'Swagger\Swagger',
            ),

            'factories' => array(
                'SwaggerModule\Options\ModuleOptions' => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    $config = (isset($config['swagger']) ? $config['swagger'] : null);

                    if($config === null) {
                        throw new RuntimeException('Configuration for SwaggerModule was not found');
                    }

                    return new SwaggerModuleOptions($config);
                },

                'Swagger\Swagger' => function($serviceManager) {
                    /** @var $options \SwaggerModule\Options\ModuleOptions */
                    $options = $serviceManager->get('SwaggerModule\Options\ModuleOptions');

                    $swagger = new SwaggerLibrary();
                    $swagger->setFileList($options->getFileList());

                    return $swagger;
                },
            )
        );
    }
}
