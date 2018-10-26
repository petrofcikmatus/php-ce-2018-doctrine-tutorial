<?php declare(strict_types=1);

namespace Authentication\Value;

final class Password
{
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public function makeHash(): PasswordHash
    {
        return PasswordHash::fromPassword($this->value);
    }

    public function verify(PasswordHash $hash): bool
    {
        return password_verify($this->value, $hash->toString());
    }
}
