<?php

namespace Authentication\Entity;

class User
{
    /** @var string */
    private $email;

    /** @var string */
    private $passwordHash;

    private function __construct(string $email, string $passwordHash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public static function createFromForm(string $email, string $password): self
    {
        return new User($email, password_hash($password, PASSWORD_BCRYPT));
    }

    public static function createFromSerializedString(string $serialized): self
    {
        [
            'email' => $email,
            'passwordHash' => $passwordHash,
        ] = unserialize($serialized);

        return new User($email, $passwordHash);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    public function serialize(): string
    {
        return serialize([
            'email' => $this->email,
            'passwordHash' => $this->passwordHash,
        ]);
    }
}
