<?php
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider);
$app->register(new DoctrineOrmServiceProvider);

$app['db.options']     = [
    'driver' => 'pdo_sqlite',
    'path'   => __DIR__ . '/data/database.db',
];
$app['orm.em.options'] = [
    'mappings' => [
        [
            'type'      => 'simple_yml',
            'namespace' => 'OboPlayground\DomainModel',
            'path'      => __DIR__ . '/../src/OboPlayground/Infrastructure/Repository',
        ],
    ],
];

return $app;
