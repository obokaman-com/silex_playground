# Silex Playground

Basic DDD playground app using Silex. Includes Doctrine ORM, Command Bus by `SimpleBus/MessageBus` & Twig.

The app allow you to add people and companies. People remain as "unemployed" since they are hired by some company. 
While you have available unemployed people and companies, you'll be able to hire (the system will randomly hire an 
available unemployee person to any of the available companies' departments.).  

1.- Run `composer install`

2.- Set up MySQL connection on `./app/app.php`. 

> You can run a Docker MySQL container ready to work with the app with the following commands:
>
> - Initial import and run MySQL image prepared to run with this app: `docker run --detach --name silex-playground-mysql --publish 3306:3306 --env "MYSQL_ROOT_PASSWORD=playground" --env "MYSQL_DATABASE=playground" mysql`.
> - Stop MySQL container: `docker stop silex-playground-mysql`
> - Remove MySQL container: `docker rm silex-playground-mysql` 
> 
> Note: If you are running Docker with Docker Toolbox you can view the VM ip with `docker-machine ip`. Use this IP to connect to MySQL.

3.- Run `bin/console orm:schema-tool:update --force` to create the needed schema in the MySQL database. 

4.- Run `php -S localhost:8000 -t ./web`

5.- Access `http://localhost:8000`

6.- Enjoy

Some additional info if you want to play around: 
* Services definition with dependencies injection and Command <> Handlers maps on `./app/services.php`
* Silex Service Providers included in `./app/app.php`
* Routing defined in `./app/controllers.php`
* Console commands defined in `./app/console.php`
* All Domain services, models and infrastructure implementations (including templates) inside `./src/`
* Public folders and dispatch scripts on `./web`
