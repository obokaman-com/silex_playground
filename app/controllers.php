<?php

use OboPlayground\Application\Service\Company\CreateCompanyCommand;
use OboPlayground\Application\Service\Company\HireRandomEmployeeCommand;
use OboPlayground\Application\Service\Company\ListCompany;
use OboPlayground\Application\Service\Company\RemoveCompanyCommand;
use OboPlayground\Application\Service\Person\CreatePersonCommand;
use OboPlayground\Application\Service\Person\EditPersonCommand;
use OboPlayground\Application\Service\Person\ListPeople;
use OboPlayground\Application\Service\Person\ListPeopleRequest;
use OboPlayground\Application\Service\Person\RemovePersonCommand;
use SimpleBus\Message\Bus\MessageBus;

$app->get(
    '/',
    function () use ($app)
    {
        /** @var ListPeople $list_persons_service */
        $list_persons_service     = $app['service.person.list'];
        /** @var ListCompany $list_companies_service */
        $list_companies_service = $app['service.company.list'];

        $employed_request    = new ListPeopleRequest('employed');
        $employed_persons_list = $list_persons_service($employed_request);

        $unemployed_request    = new ListPeopleRequest('unemployed');
        $unemployed_persons_list = $list_persons_service($unemployed_request);

        $companies_list = $list_companies_service();

        return $app['twig']->render(
            'index.html.twig',
            array(
                'employed'   => $employed_persons_list,
                'unemployed' => $unemployed_persons_list,
                'companies'  => $companies_list,
            )
        );
    }
)->bind('homepage');

$app->get(
    '/create-company',
    function () use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];
        $faker       = Faker\Factory::create('en_US');

        $create_company_command = new CreateCompanyCommand($faker->company);
        $command_bus->handle($create_company_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('create_company');

$app->get(
    '/remove-company/{company_id}',
    function ($company_id) use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];

        $create_company_command = new RemoveCompanyCommand($company_id);
        $command_bus->handle($create_company_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('remove_company');

$app->get(
    '/random-hire',
    function () use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];

        $random_hire_command = new HireRandomEmployeeCommand();
        $command_bus->handle($random_hire_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('random_hire');

$app->get(
    '/create-person',
    function () use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];
        $faker       = Faker\Factory::create('en_US');

        $create_person_command = new CreatePersonCommand($faker->email, $faker->name);
        $command_bus->handle($create_person_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('create_person');

$app->get(
    '/edit-person/{person_id}',
    function ($person_id) use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];
        $faker       = Faker\Factory::create('en_US');

        $edit_person_command = new EditPersonCommand($person_id, $faker->email, $faker->name);
        $command_bus->handle($edit_person_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('edit_person');

$app->get(
    '/remove-person/{person_id}',
    function ($person_id) use ($app)
    {
        /** @var MessageBus $command_bus */
        $command_bus = $app['command_bus'];

        $remove_person_command = new RemovePersonCommand($person_id);
        $command_bus->handle($remove_person_command);

        return $app->redirect($app["url_generator"]->generate("homepage"));
    }
)->bind('remove_person');
