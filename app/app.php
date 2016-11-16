<?php
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes\CompanyIdCustomType;
use OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes\DepartmentIdCustomType;
use OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes\EmailCustomType;
use OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes\EmployeeIdCustomType;
use OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes\PersonIdCustomType;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;
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
$app->register(new DoctrineOrmManagerRegistryProvider());

$app['db.options']     = [
    'driver'   => 'mysqli',
    'user'     => 'root',
    'password' => 'playground',
    'host'     => '127.0.0.1',
    'dbname'   => 'playground'
];
$app['orm.em.options'] = [
    'mappings' => [
        [
            'type'      => 'simple_yml',
            'namespace' => 'OboPlayground\Domain\Model',
            'path'      => __DIR__ . '/../src/OboPlayground/Infrastructure/Repository/Doctrine/Config/Mappings',
        ],
    ],
];

/** @var \Doctrine\DBAL\Connection $conn */
$conn = $app['doctrine']->getConnection();

Type::addType('email', EmailCustomType::class);
Type::addType('person_id', PersonIdCustomType::class);
Type::addType('employee_id', EmployeeIdCustomType::class);
Type::addType('department_id', DepartmentIdCustomType::class);
Type::addType('company_id', CompanyIdCustomType::class);
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_email', 'email');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_person_id', 'person_id');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_employee_id', 'employee_id');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_department_id', 'department_id');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('dm_company_id', 'company_id');

return $app;
