# SwaggerModule

A Zend Framework module that allows the generation of Swagger compliant resource files and is based on [swagger-php](https://github.com/zircote/swagger-php).

## Installation
The recommended way to install
[`outeredge/swagger-module`](https://packagist.org/packages/outeredge/swagger-module) is through
[composer](http://getcomposer.org/):

```sh
php composer.phar require outeredge/swagger-module
```

You can then enable this module in your `config/application.config.php` by adding
`SwaggerModule` to the `modules` key:

```php
// ...
    'modules' => array(
        // ...
        'SwaggerModule'
    ),
```

## Configuration

Copy `config/module.swagger.global.php.dist` to your config/autoload folder and modify paths variable

## Usage
See [swagger-php](https://github.com/zircote/swagger-php#readme) for library usage information.

```php
$swagger = $this->getServiceLocator()->get('service.swagger');
echo $swagger->getResource('http://org.local/v1');
```
