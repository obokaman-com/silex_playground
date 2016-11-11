<?php
use OboPlayground\Application\EventAwareMiddleware;
use OboPlayground\Application\Service\CreateUser;
use OboPlayground\Application\Service\CreateUserCommand;
use OboPlayground\Application\Service\ListUser;
use OboPlayground\Application\TransactionalMiddleware;
use OboPlayground\Domain\Model\UserHasBeenRegistered;
use OboPlayground\Infrastructure\Event\Symfony\EventDispatcher;
use OboPlayground\Infrastructure\Repository\User\UserRepositoryDoctrine;
use OboPlayground\Infrastructure\Repository\User\UserRepositoryInMemory;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

/** APPLICATION SERVICES */
$app['service.user.create'] = function ($app)
{
    return new CreateUser($app['repository.user']);
};

$app['service.user.list'] = function ($app)
{
    return new ListUser($app['repository.user']);
};

/** REPOSITORIES */
$app['repository.user.in_memory'] = function ()
{
    return new UserRepositoryInMemory();
};

$app['repository.user.doctrine'] = function ($app)
{
    return new UserRepositoryDoctrine($app['orm.em']);
};

$app['repository.user'] = function ($app)
{
    return $app['repository.user.doctrine'];
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
            CreateUserCommand::class => 'service.user.create'
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
    $command_bus->prependMiddleware(new TransactionalMiddleware($app['orm.em']));

    return $command_bus;
};

/** EVENTS MAPPING */
$app->on(
    UserHasBeenRegistered::EVENT_KEY,
    function ()
    {
        // Do something cool here when user has been registered.
    }
);
