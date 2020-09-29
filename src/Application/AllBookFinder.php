<?php


namespace App\Application;


use App\Repository\BookRepository;

class AllBookFinder
{
    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAll(): array {
        return $this->repository->searchAll();
    }

}