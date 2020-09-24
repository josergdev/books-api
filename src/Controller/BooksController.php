<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    private BookRepository $repository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->repository = $bookRepository;
    }

    /**
     * @Route("/books/{isbn}", methods={"GET"})
     * @param string $isbn
     * @return JsonResponse
     */
    public function get(string $isbn): JsonResponse
    {
        $book = $this->repository->search($isbn);

        return new JsonResponse(
            [
                'isbn' => $book->isbn(),
                'title' => $book->title(),
                'author' => $book->author()
            ]
        );
    }

    /**
     * @Route("/books", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $books = $this->repository->searchAll();

        $book_mapper = function (Book $book)
        {
            return [
                'isbn' => $book->isbn(),
                'title' => $book->title(),
                'author' => $book->author()
            ];
        };

        return new JsonResponse(
            array_map($book_mapper, $books)
        );
    }

    /**
     * @Route("/books", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $isbn = $data['isbn'];
        $title = $data['title'];
        $author = $data['author'];

        $book = new Book($isbn, $title, $author);

        $this->repository->save($book);

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/books/{isbn}", methods={"PUT"})
     * @param string $isbn
     * @param Request $request
     * @return Response
     */
    public function update(string $isbn, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $title = $data['title'];
        $author = $data['author'];

        $book = $this->repository->search($isbn);

        $book->updateTitle($title);
        $book->updateAuthor($author);

        $this->repository->save($book);

        return new Response('', Response::HTTP_OK);
    }

}