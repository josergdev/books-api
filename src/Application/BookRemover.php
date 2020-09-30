<?php

namespace App\Application;

use App\Entity\Isbn;
use App\Repository\BookRepository;

class BookRemover
{
    private BookFinder $finder;
    private BookRepository $repository;

    public function __construct(BookFinder $finder, BookRepository $repository)
    {
        $this->finder = $finder;
        $this->repository = $repository;
    }

    public function remove(Isbn $isbn): void
    {
        $book = $this->finder->find($isbn);

        $this->repository->remove($book);
    }
}