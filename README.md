PostgreSQL Doctrine Bundle
==============

Description
------------

Provides symfony-bridge for [pfilsx/postgresql-doctrine](https://github.com/pfilsx/PostgreSQLDoctrine) package.

Features
--------
* See [pfilsx/postgresql-doctrine](https://github.com/pfilsx/PostgreSQLDoctrine)

Requirement
-----------
* PHP ^8.1
* doctrine/dbal ^3.5.1
* doctrine/migrations ^3.5.2

Installation
------------

Open a command console, enter your project directory and execute the following command to download the latest version of this bundle:
```bash
composer require pfilsx/postgresql-doctrine-bundle
```

Register bundle into ``config/bundles.php`` (Flex did it automatically):
``` php
return [
    ...
    Pfilsx\PostgreSQLDoctrineBundle\PostgreSQLDoctrineBundle::class => ['all' => true],
];
```