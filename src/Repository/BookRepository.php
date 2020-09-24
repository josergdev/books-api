<?php

namespace App\Repository;

use App\Entity\Book;

interface BookRepository
{
    public function save(Book $book): void;

    public function remove(Book $book): void;

    public function search(string $isbn): ?Book;

    public function searchByTitle(string $title): ?Book;

    public function searchAll(): array;
}