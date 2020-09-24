<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineBookRepository implements BookRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }

    public function remove(Book $book): void
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }

    public function search(string $isbn): ?Book
    {
        return $this->entityManager->getRepository(Book::class)->find($isbn);
    }

    public function searchByTitle(string $title): ?Book
    {
        return $this->entityManager->getRepository(Book::class)->findOneBy(['title' => $title]);
    }

    public function searchAll(): array
    {
        return $this->entityManager->getRepository(Book::class)->findAll();
    }
}