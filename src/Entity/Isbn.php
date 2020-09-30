<?php

namespace App\Entity;

use App\Exceptions\ISBNNotValid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Isbn
{
    private const LENGTH = 13;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=13, name="isbn") )
     */
    private string $value;

    public function __construct(string $isbn)
    {
        $this->ensureIsValidIsbn($isbn);
        $this->value = $isbn;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Isbn $isbn)
    {
        return $this->value() === $isbn->value();
    }

    private function ensureIsValidIsbn(string $isbn): void
    {
        $hasAllDigits = ctype_digit($isbn);
        $hasValidLength = strlen($isbn) == self::LENGTH;

        if (!$hasAllDigits or !$hasValidLength) {
            throw new ISBNNotValid();
        }
    }

}