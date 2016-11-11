<?php

namespace OboPlayground\Application;

use Doctrine\ORM\EntityManager;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

final class TransactionalMiddleware implements MessageBusMiddleware
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->em = $an_entity_manager;
    }

    public function handle($message, callable $next_middleware)
    {
        $this->em->getConnection()->beginTransaction();
        try
        {
            $next_middleware($message);
            $this->em->getConnection()->commit();
        }
        catch (\Exception $e)
        {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }
}
