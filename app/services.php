<?php
use Doctrine\Common\Cache\FilesystemCache;
use OboPlayground\Application\EventAwareMiddleware;
use OboPlayground\Application\Service\CreateUser;
use OboPlayground\Application\Service\CreateUserCommand;
use OboPlayground\Application\Service\EditUser;
use OboPlayground\Application\Service\EditUserCommand;
use OboPlayground\Application\Service\ListUser;
use OboPlayground\Application\Service\RemoveUser;
use OboPlayground\Application\Service\RemoveUserCommand;
use OboPlayground\Application\TransactionalMiddleware;
use OboPlayground\Domain\Model\UserEmailHasChanged;
use OboPlayground\Domain\Model\UserHasBeenRegistered;
use OboPlayground\Domain\Model\UserNameHasChanged;
use OboPlayground\Infrastructure\Event\Symfony\EventDispatcher;
use OboPlayground\Infrastructure\Repository\Doctrine\User\UserRepositoryDoctrine;
use OboPlayground\Infrastructure\Repository\Doctrine\User\UserRepositoryFilesystem;
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

$app['service.user.edit'] = function ($app)
{
    return new EditUser($app['repository.user']);
};

$app['service.user.remove'] = function ($app)
{
    return new RemoveUser($app['repository.user']);
};

$app['service.user.list'] = function ($app)
{
    return new ListUser($app['repository.user']);
};

/** REPOSITORIES */
$app['repository.user.filesystem'] = function ()
{
    return new UserRepositoryFilesystem(new FilesystemCache(__DIR__ . '/data'));
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
            CreateUserCommand::class => 'service.user.create',
            EditUserCommand::class   => 'service.user.edit',
            RemoveUserCommand::class => 'service.user.remove'
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
$app->on(UserNameHasChanged::EVENT_KEY, function (){});
$app->on(UserEmailHasChanged::EVENT_KEY, function (){});
