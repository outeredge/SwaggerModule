# SwaggerModule

A ZF2 module that allows the generation of Swagger compliant resource files and is based on [swagger-php](https://github.com/zircote/swagger-php). 

## Requirements
 - PHP 5.3 or higher
 - [Zend Framework 2](http://www.github.com/zendframework/zf2)

## Installation
Installation of SwaggerModule uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

#### Installation steps

  1. `cd my/project/directory`
  2. create a `composer.json` file with following contents:

     ```json
     {
         "require": {
             "outeredge/SwaggerModule": "dev-master"
         }
     }
     ```
  3. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  4. run `php composer.phar install`
  5. copy config/module.swagger.global.php.dist to your config/autoload folder and modify paths variable
  6. open `my/project/directory/configs/application.config.php` and add the following key to your `modules`:

     ```php
     'SwaggerModule',
     ```

## Usage
See [swagger-php](https://github.com/zircote/swagger-php#readme) for library usage information.

```php
$swagger = $this->getServiceLocator()->get('service.swagger');
echo $swagger->getResource('http://org.local/v1');
```