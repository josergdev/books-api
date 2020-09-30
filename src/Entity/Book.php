<?php

namespace App\Entity;

use App\Entity\Isbn;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="books")
 */
class Book
{
    /**
     * @ORM\Embedded(class = "Isbn", columnPrefix = false)
     */
    private Isbn $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $author;

    public function __construct(Isbn $isbn, string $title, string $author)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
    }

    public function isbn(): Isbn
    {
        return $this->isbn;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function updateTitle(string $title): void
    {
        $this->title = $title;
    }

    public function updateAuthor(string $author): void
    {
        $this->author = $author;
    }
}