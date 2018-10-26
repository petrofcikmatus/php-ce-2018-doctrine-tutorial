<?php

namespace Authentication\Entity;

use Authentication\Value\Email;
use Authentication\Value\PasswordHash;

class User
{
    /** @var Email */
    private $email;

    /** @var PasswordHash */
    private $passwordHash;

    public function __construct(Email $email, PasswordHash $passwordHash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public static function createFromSerializedString(string $serialized): self
    {
        [
            'email' => $email,
            'passwordHash' => $passwordHash,
        ] = unserialize($serialized);

        return new User(Email::fromEmail($email), PasswordHash::fromPasswordHash($passwordHash));
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function verifyPassword(string $password): bool
    {
        return $this->passwordHash->verify($password);
    }

    public function serialize(): string
    {
        return serialize([
            'email' => $this->email->toString(),
            'passwordHash' => $this->passwordHash->toString(),
        ]);
    }
}
