<?php

namespace OboPlayground\Application;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

final class TransactionalMiddleware implements MessageBusMiddleware
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(ManagerRegistry $a_manager_registry)
    {
        $this->em = $a_manager_registry->getManager();
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
