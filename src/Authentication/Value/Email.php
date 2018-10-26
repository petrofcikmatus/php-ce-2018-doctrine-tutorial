<?php declare(strict_types=1);

namespace Authentication\Value;

final class Email
{
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromEmail(string $email): self
    {
        if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException();
        }

        return new self($email);
    }

    public function isValid(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
