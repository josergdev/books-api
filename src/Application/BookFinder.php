<?php

namespace App\Application;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookFinder
{
    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $isbn) : Book
    {
        $book = $this->repository->search($isbn);

        $this->ensureBookExist($book, $isbn);

        return $book;
    }

    private function ensureBookExist(?Book $book, string $isbn): void
    {
        if (is_null($book)) {
            throw new BookNotExist($isbn);
        }
    }

}