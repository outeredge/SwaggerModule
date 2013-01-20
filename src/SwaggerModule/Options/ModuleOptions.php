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

namespace SwaggerModule\Options;

use DirectoryIterator;
use Zend\Stdlib\AbstractOptions;

/**
 * ModuleOptions
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Array of paths
     *
     * @var array
     */
    protected $paths;


    /**
     * Set an array of paths where the files to be scanned by Swagger are searched
     *
     * @param  array $paths
     * @throws Exception\RuntimeException
     * @return ModuleOptions
     */
    public function setPaths(array $paths)
    {
        if(count($paths) < 1) {
            throw new Exception\RuntimeException('No path(s) were specified for SwaggerModule');
        }

        foreach ($paths as $path) {
            if (!is_dir($path)) {
                throw new Exception\RuntimeException(sprintf(
                    'Path %s given to SwaggerModule is invalid',
                    $path
                ));
            }
        }

        $this->paths = $paths;

        return $this;
    }

    /**
     * Get the array of paths where to files to be scanned by Swagger are searched
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Get a list of files to be scanned by Swagger
     *
     * @return array
     */
    public function getFileList()
    {
        $fileList = array();

        foreach ($this->paths as $path) {
            $directoryIterator = new DirectoryIterator($path);

            /** @var $file DirectoryIterator */
            foreach ($directoryIterator as $file) {
                if (!$file->isDir()) {
                    $fileList[] = $file->getPathname();
                }
            }
        }

        return $fileList;
    }
}
