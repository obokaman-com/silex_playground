<?php
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Infrastructure\Repository\Doctrine\CustomTypes\EmailCustomType;
use OboPlayground\Infrastructure\Repository\Doctrine\CustomTypes\UserIdCustomType;
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
            'namespace' => 'OboPlayground\Domain\Model',
            'path'      => __DIR__ . '/../src/OboPlayground/Infrastructure/Repository/Doctrine/Mappings',
        ],
    ],
];

/** @var \Doctrine\ORM\EntityManagerInterface $em */
$em   = $app['orm.em'];
$conn = $em->getConnection();

Type::addType('email', EmailCustomType::class);
Type::addType('user_id', UserIdCustomType::class);
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_email', 'email');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_user_id', 'user_id');

return $app;
