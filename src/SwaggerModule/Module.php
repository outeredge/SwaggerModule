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
use SwaggerModule\Options\ModuleOptions as SwaggerModuleOptions;
use Swagger\StaticAnalyser as SwaggerStaticAnalyser;
use Swagger\Analysis as SwaggerAnalysis;
use Swagger\Util as SwaggerUtil;
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
                'service.swagger' => 'Swagger\Annotations\Swagger',
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

                'Swagger\Annotations\Swagger' => function($serviceManager) {
                    /** @var $options \SwaggerModule\Options\ModuleOptions */
                    $options = $serviceManager->get('SwaggerModule\Options\ModuleOptions');
                    $analyser = new SwaggerStaticAnalyser();
                    $analysis = new SwaggerAnalysis();
                    $processors = SwaggerAnalysis::processors();

                    // Crawl directory and parse all files
                    $paths = $options->getPaths();
                    foreach($paths as $directory) {
                        $finder = SwaggerUtil::finder($directory);
                        foreach ($finder as $file) {
                            $analysis->addAnalysis($analyser->fromFile($file->getPathname()));
                        }
                    }
                    // Post processing
                    $analysis->process($processors);
                    // Validation (Generate notices & warnings)
                    $analysis->validate();

                    // Pass options to analyzer
                    $resourceOptions = $options->getResourceOptions();
                    if(!empty($resourceOptions['defaultBasePath'])) {
                        $analysis->swagger->basePath = $resourceOptions['defaultBasePath'];
                    }
                    if(!empty($resourceOptions['defaultHost'])) {
                        $analysis->swagger->host = $resourceOptions['defaultHost'];
                    }
                    if(!empty($resourceOptions['schemes'])) {
                        $analysis->swagger->schemes = $resourceOptions['schemes'];
                    }

                    return $analysis->swagger;
                },
            )
        );
    }
}
