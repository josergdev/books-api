<?php

namespace App\Application;

use App\Domain\BookAlreadyExists;
use App\Repository\BookRepository;
use Psr\Log\LoggerInterface;

class BookUpdater
{
    private BookFinder $finder;
    private BookRepository $repository;
    private LoggerInterface $logger;

    public function __construct(BookFinder $finder, BookRepository $repository, LoggerInterface $logger)
    {
        $this->finder = $finder;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function update(string $isbn, string $title, string $author): void
    {
        $book = $this->finder->find($isbn);

        $this->ensureNotDuplicateBook($isbn, $title);

        $book->updateTitle($title);
        $book->updateAuthor($author);

        $this->repository->save($book);
    }

    public function ensureNotDuplicateBook(string $isbn, string $title): void
    {
        $sameTitleBook = $this->repository->searchByTitle($title);

        if (!is_null($sameTitleBook) and $sameTitleBook->isbn() != $isbn) {
            throw new BookAlreadyExists("A book with the same title cannot be added twice.");
        }

        $this->logger->info("book is null");
    }

}