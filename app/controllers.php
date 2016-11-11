<?php

use OboPlayground\ApplicationService\CreateUserCommand;
use OboPlayground\ApplicationService\ListUser;
use SimpleBus\Message\Bus\MessageBus;

$app->get(
    '/',
    function () use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];

        $create_user1_command = new CreateUserCommand("albert.garcia@uvinum.com", "Albert Garcia");
        $command_bus->handle($create_user1_command);

        $create_user2_command = new CreateUserCommand("obokaman@gmail.com", "Obokaman");
        $command_bus->handle($create_user2_command);

        /** @var ListUser $list_users_service */
        $list_users_service = $app['service.user.list'];

        $users_list = $list_users_service();

        return $app['twig']->render(
            'index.html.twig',
            array(
                'content' => $users_list,
            )
        );
    }
)->bind('homepage');
