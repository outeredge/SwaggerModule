SwaggerModule
=============

A ZF2 module that allows the generation of Swagger compliant resource files and is based on [swagger-php](https://github.com/zircote/swagger-php). 

Installation
------------

1. git clone --recursive git://github.com/outeredge/SwaggerModule.git vendor/SwaggerModule
2. Copy config/module.swagger_module.config.php.dist to your Application's config/autoload folder and modify path variable


Usage
-----
See [swagger-php](https://github.com/zircote/swagger-php#readme) for library usage information.

```php
$swagger = $this->getLocator()->get('Swagger\Swagger');
echo $swagger->getResource('http://org.local/v1');
```