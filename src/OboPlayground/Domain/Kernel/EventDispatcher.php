<?php

namespace OboPlayground\Domain\Kernel;

interface EventDispatcher
{
    public function dispatch(DomainEvent $an_event);
}
