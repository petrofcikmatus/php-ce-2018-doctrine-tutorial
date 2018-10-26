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

    public static function fromString(string $value): self
    {
        if (!\filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException();
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
