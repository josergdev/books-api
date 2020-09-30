<?php

namespace App\Application;

use App\Exceptions\BookNotExist;
use App\Entity\Book;
use App\Entity\Isbn;
use App\Repository\BookRepository;

class BookFinder
{
    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(Isbn $isbn): Book
    {
        $book = $this->repository->search($isbn);

        $this->ensureBookExist($book, $isbn);

        return $book;
    }

    private function ensureBookExist(?Book $book, Isbn $isbn): void
    {
        if (is_null($book)) {
            throw new BookNotExist();
        }
    }

}