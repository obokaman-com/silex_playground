<?php

namespace OboPlayground\Domain\Kernel;

final class EventRecorder
{
    /** @var EventRecorder */
    private static $instance;

    /** @var DomainEvent[] */
    private $events = [];

    public static function instance()
    {
        if (null === static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function recordEvent(DomainEvent $an_event)
    {
        array_push($this->events, $an_event);
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function clearEvents()
    {
        $this->events = [];
    }
}
