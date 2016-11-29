<?php
use OboPlayground\Application\EventAwareMiddleware;
use OboPlayground\Application\Service\Company\CreateCompany;
use OboPlayground\Application\Service\Company\CreateCompanyCommand;
use OboPlayground\Application\Service\Company\HireRandomEmployee;
use OboPlayground\Application\Service\Company\HireRandomEmployeeCommand;
use OboPlayground\Application\Service\Company\ListCompany;
use OboPlayground\Application\Service\Company\RemoveCompany;
use OboPlayground\Application\Service\Company\RemoveCompanyCommand;
use OboPlayground\Application\Service\Person\CreatePerson;
use OboPlayground\Application\Service\Person\CreatePersonCommand;
use OboPlayground\Application\Service\Person\EditPerson;
use OboPlayground\Application\Service\Person\EditPersonCommand;
use OboPlayground\Application\Service\Person\ListPeople;
use OboPlayground\Application\Service\Person\RemovePerson;
use OboPlayground\Application\Service\Person\RemovePersonCommand;
use OboPlayground\Application\TransactionalMiddleware;
use OboPlayground\Domain\Model\Person\PersonEmailHasChanged;
use OboPlayground\Domain\Model\Person\PersonHasBeenRegistered;
use OboPlayground\Domain\Model\Person\PersonNameHasChanged;
use OboPlayground\Infrastructure\Event\Symfony\EventDispatcher;
use OboPlayground\Infrastructure\Repository\Doctrine\Company\CompanyRepository;
use OboPlayground\Infrastructure\Repository\Doctrine\Person\PersonRepository;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

/** APPLICATION SERVICES */
$app['service.person.create'] = function ($app)
{
    return new CreatePerson($app['repository.person']);
};

$app['service.person.edit'] = function ($app)
{
    return new EditPerson($app['repository.person']);
};

$app['service.person.remove'] = function ($app)
{
    return new RemovePerson($app['repository.person']);
};

$app['service.person.list'] = function ($app)
{
    return new ListPeople($app['repository.person']);
};

$app['service.company.create'] = function ($app)
{
    return new CreateCompany($app['repository.company']);
};

$app['service.company.remove'] = function ($app)
{
    return new RemoveCompany($app['repository.company']);
};

$app['service.company.hire_random'] = function ($app)
{
    return new HireRandomEmployee($app['repository.company'], $app['repository.person']);
};

$app['service.company.list'] = function ($app)
{
    return new ListCompany($app['repository.company']);
};

/** REPOSITORIES */
$app['repository.person.doctrine'] = function ($app)
{
    return new PersonRepository($app['doctrine']);
};

$app['repository.person'] = function ($app)
{
    return $app['repository.person.doctrine'];
};

$app['repository.company.doctrine'] = function ($app)
{
    return new CompanyRepository($app['doctrine']);
};

$app['repository.company'] = function ($app)
{
    return $app['repository.company.doctrine'];
};

$app['event_dispatcher'] = function ($app)
{
    return new EventDispatcher($app['dispatcher']);
};

/** COMMAND HANDLERS MAPPING */
$app['command_bus'] = function ($app)
{
    $command_bus = new MessageBusSupportingMiddleware();

    $commandHandlerMap = new CallableMap(
        [
            CreateCompanyCommand::class      => 'service.company.create',
            RemoveCompanyCommand::class      => 'service.company.remove',
            HireRandomEmployeeCommand::class => 'service.company.hire_random',
            CreatePersonCommand::class       => 'service.person.create',
            EditPersonCommand::class         => 'service.person.edit',
            RemovePersonCommand::class       => 'service.person.remove'
        ], new ServiceLocatorAwareCallableResolver(
            function ($service) use ($app)
            {
                return $app[$service];
            }
        )
    );

    $command_bus->appendMiddleware(
        new DelegatesToMessageHandlerMiddleware(
            new NameBasedMessageHandlerResolver(
                new ClassBasedNameResolver(), $commandHandlerMap
            )
        )
    );

    $command_bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());

    $command_bus->prependMiddleware(new EventAwareMiddleware($app['event_dispatcher']));
    $command_bus->prependMiddleware(new TransactionalMiddleware($app['doctrine']));

    return $command_bus;
};

/** EVENTS MAPPING */
$app->on(
    PersonHasBeenRegistered::EVENT_KEY,
    function ()
    {
        // Do something cool here when person has been registered.
    }
);
$app->on(
    PersonNameHasChanged::EVENT_KEY,
    function ()
    {
    }
);
$app->on(
    PersonEmailHasChanged::EVENT_KEY,
    function ()
    {
    }
);
