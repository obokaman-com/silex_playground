<?php

use OboPlayground\Application\Service\CreateUserCommand;
use OboPlayground\Application\Service\EditUserCommand;
use OboPlayground\Application\Service\ListUser;
use OboPlayground\Application\Service\RemoveUserCommand;
use OboPlayground\Domain\Model\UserNotFoundException;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\HttpFoundation\Response;

$app->get(
    '/',
    function () use ($app)
    {
        /** @var ListUser $list_users_service */
        $list_users_service = $app['service.user.list'];

        $users_list = $list_users_service();

        return $app['twig']->render(
            'index.html.twig',
            array(
                'users' => $users_list,
            )
        );
    }
)->bind('homepage');

$app->get(
    '/create-user',
    function () use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];
        $faker       = Faker\Factory::create('es_ES');

        $create_user_command = new CreateUserCommand($faker->email, $faker->name);
        $command_bus->handle($create_user_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('create_user');

$app->get(
    '/edit-user/{user_id}',
    function ($user_id) use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];
        $faker       = Faker\Factory::create('es_ES');

        try
        {
            $edit_user_command = new EditUserCommand($user_id, $faker->email, $faker->name);
            $command_bus->handle($edit_user_command);

            return $app->redirect($app["url_generator"]->generate("homepage"));
        }
        catch(UserNotFoundException $e)
        {
            return new Response('', 404);
        }
    }
)->bind('edit_user');

$app->get(
    '/remove-user/{user_id}',
    function ($user_id) use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];

        $remove_user_command = new RemoveUserCommand($user_id);
        $command_bus->handle($remove_user_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('remove_user');
