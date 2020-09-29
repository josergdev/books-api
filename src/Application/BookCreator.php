<?php


namespace App\Application;


use App\Domain\BookAlreadyExists;
use App\Entity\Book;
use App\Repository\BookRepository;

class BookCreator
{
    private BookRepository $repository;
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $isbn, string $title, string $author): void
    {
        $this->ensureNotDuplicateBook($isbn, $title);

        $book = new Book($isbn, $title, $author);

        $this->repository->save($book);
    }

    private function ensureNotDuplicateBook(string $isbn, string $title): void
    {
        $book = $this->repository->search($isbn);
        if (!is_null($book)) {
            throw new BookAlreadyExists("A book with the same isbn cannot be added twice.");
        }

        $book = $this->repository->searchByTitle($title);
        if (!is_null($book)) {
            throw new BookAlreadyExists("A book with the same title cannot be added twice.");
        }
    }

}