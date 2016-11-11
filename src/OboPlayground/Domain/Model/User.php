<?php

namespace OboPlayground\Domain\Model;

use OboPlayground\Domain\Kernel\EventRecorder;

final class User implements \JsonSerializable
{
    /** @var UserId */
    private $user_id;

    /** @var Email */
    private $email;

    /** @var string */
    private $name;

    public function __construct(UserId $an_user_id, Email $an_email, $a_name)
    {
        $this->user_id = $an_user_id;
        $this->email   = $an_email;
        $this->name    = $a_name;
    }

    public static function register(UserId $a_user_id, Email $an_email, string $a_name)
    {
        EventRecorder::instance()->recordEvent(new UserHasBeenRegistered($a_user_id, $an_email, $a_name));

        return new self($a_user_id, $an_email, $a_name);
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function email()
    {
        return $this->email;
    }

    public function name()
    {
        return $this->name;
    }

    function jsonSerialize()
    {
        return [
            'user_id' => (string) $this->user_id,
            'email'   => (string) $this->email,
            'name'    => $this->name
        ];
    }
}
