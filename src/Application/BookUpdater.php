<?php

namespace App\Application;

use App\Exceptions\BookAlreadyExists;
use App\Entity\Isbn;
use App\Repository\BookRepository;
use Psr\Log\LoggerInterface;

class BookUpdater
{
    private BookFinder $finder;
    private BookRepository $repository;

    public function __construct(BookFinder $finder, BookRepository $repository)
    {
        $this->finder = $finder;
        $this->repository = $repository;
    }

    public function update(Isbn $isbn, string $title, string $author): void
    {
        $book = $this->finder->find($isbn);

        $this->ensureNotDuplicateBook($isbn, $title);

        $book->updateTitle($title);
        $book->updateAuthor($author);

        $this->repository->save($book);
    }

    public function ensureNotDuplicateBook(Isbn $isbn, string $title): void
    {
        $sameTitleBook = $this->repository->searchByTitle($title);

        if (!is_null($sameTitleBook) and !$sameTitleBook->isbn()->equals($isbn)) {
            throw new BookAlreadyExists("A book with the same title cannot be added twice.");
        }
    }

}