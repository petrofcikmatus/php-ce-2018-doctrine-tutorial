<?php declare(strict_types=1);

namespace Authentication\Value;

final class PasswordHash
{
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromPassword(string $password): self
    {
        return new self(password_hash($password, PASSWORD_BCRYPT));
    }

    public static function fromPasswordHash(string $passwordHash): self
    {
        // todo: add validation that hash starts with $ sign
        return new self($passwordHash);
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
