<?php

namespace OboPlayground\Domain\Kernel;

abstract class DomainEvent
{
    const EVENT_KEY = 'should.redefine.in.children';

    /** @var \DateTimeImmutable */
    protected $occurred_on;

    public function __construct()
    {
        $this->occurred_on = new \DateTimeImmutable('now');
    }

    public function occurredOn()
    {
        if (null === $this->occurred_on)
        {
            throw new \DomainException(
                'You should call parent::__construct from ' . self::class . ' in order to save occurred_on property.'
            );
        }

        return $this->occurred_on;
    }

    public function getName()
    {
        return get_class($this);
    }
}
