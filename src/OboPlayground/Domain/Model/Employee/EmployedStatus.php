<?php

namespace OboPlayground\Domain\Model\Employee;

final class EmployedStatus
{
    const EMPLOYED = 'employed';
    const UNEMPLOYED = 'unemployed';

    const AVAILABLE_STATUS = [
        self::EMPLOYED,
        self::UNEMPLOYED
    ];

    private $status;

    private function __construct($status)
    {
        $this->validateInput($status);

        $this->status = $status;
    }

    public static function EMPLOYED()
    {
        return new self(self::EMPLOYED);
    }

    public static function UNEMPLOYED()
    {
        return new self(self::UNEMPLOYED);
    }

    public static function fromString($value)
    {
        self::validateInput($value);

        return new self($value);
    }

    private static function validateInput($status)
    {
        if (!in_array($status, self::AVAILABLE_STATUS))
        {
            throw new \InvalidArgumentException('Invalid employed status.');
        }
    }

    public function isUnemployed()
    {
        return $this->status == self::UNEMPLOYED;
    }

    public function isEmployed()
    {
        return $this->status == self::EMPLOYED;
    }
}
