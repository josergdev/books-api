<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="books")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private string $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $author;

    public function __construct(string $isbn, string $title, string $author)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
    }

    public function isbn(): string
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

    public function updateTitle($title): void
    {
        $this->title = $title;
    }

    public function updateAuthor($author): void
    {
        $this->author = $author;
    }
}