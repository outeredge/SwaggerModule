SwaggerModule
=============

A ZF2 module that allows the generation of Swagger compliant resource files and is based on [swagger-php](https://github.com/zircote/swagger-php). 

Installation
------------

git clone --recursive git://github.com/outeredge/SwaggerModule.git vendor/SwaggerModule

Usage
-----
See [swagger-php](https://github.com/zircote/swagger-php#readme) for library usage information.

```php
$swagger = $this->getLocator()->get('Swagger\Swagger');
echo $swagger->getResource('http://org.local/v1');
```