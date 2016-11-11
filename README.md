# Silex Playground

Basic DDD playground app using Silex. Includes Doctrine ORM, Command Bus by `SimpleBus/MessageBus` & Twig.

1. `composer install`
2. `bin/console orm:schema-tool:create` (This will create an empty SQLite database in `./app/data/database.db` based on Doctrine entities mapping located on `./src/OboPlayground/Infrastructure/Repository/*.orm.yml`)
3. `composer run`
4. Access `http://localhost:8000`
5. Enjoy

Some additional info if you want to play around: 
* Services definition with dependencies injection and Command <> Handlers maps on `./app/services.php`
* Silex Service Providers included in `./app/app.php`
* Routing defined in `./app/controllers.php`
* Console commands defined in `./app/console.php`
* All Domain services, models and infrastructure implementations (including templates) inside `./src/`
* Public folders and dispatch scripts on `./web`
