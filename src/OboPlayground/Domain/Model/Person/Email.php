<?php

namespace OboPlayground\Domain\Model\Person;

final class Email
{
    /** @var string */
    private $email;

    public function __construct(string $an_email)
    {
        if (!filter_var($an_email, FILTER_VALIDATE_EMAIL))
        {
            throw new \InvalidArgumentException('Invalid email: ' . $an_email);
        }
        $this->email = mb_strtolower($an_email);
    }

    public function email()
    {
        return $this->email;
    }

    public function equals(self $a_new_email)
    {
        return $this->email === $a_new_email->email;
    }

    public function __toString()
    {
        return $this->email;
    }
}
