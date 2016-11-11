<?php
/**
 * Created by PhpStorm.
 * User: albertgarcia
 * Date: 11/11/16
 * Time: 14:16
 */

namespace OboPlayground\Application;

use OboPlayground\Domain\Kernel\EventDispatcher;
use OboPlayground\Domain\Kernel\EventRecorder;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

final class EventAwareMiddleware implements MessageBusMiddleware
{
    /** @var EventDispatcher */
    private $event_dispatcher;

    public function __construct(EventDispatcher $an_event_dispatcher)
    {
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function handle($message, callable $new_middleware)
    {
        $this->clearEvents();

        $new_middleware($message);

        $events = EventRecorder::instance()->getEvents();

        $this->dispatchEvents($events);
    }

    private function clearEvents()
    {
        EventRecorder::instance()->clearEvents();
    }

    private function dispatchEvents($events)
    {
        foreach ($events as $event)
        {
            $this->event_dispatcher->dispatch($event);
        }
    }
}
