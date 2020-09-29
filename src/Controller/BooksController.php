<?php

namespace App\Controller;

use App\Application\AllBookFinder;
use App\Application\BookCreator;
use App\Application\BookFinder;
use App\Application\BookRemover;
use App\Application\BookUpdater;
use App\Domain\BookAlreadyExists;
use App\Domain\BookNotExist;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    private BookFinder $finder;
    private AllBookFinder $allFinder;
    private BookCreator $creator;
    private BookUpdater $updater;
    private BookRemover $remover;

    public function __construct(
        BookFinder $finder,
        AllBookFinder $allFinder,
        BookCreator $creator,
        BookUpdater $updater,
        BookRemover $remover)
    {
        $this->finder = $finder;
        $this->allFinder = $allFinder;
        $this->creator = $creator;
        $this->updater = $updater;
        $this->remover = $remover;
    }

    /**
     * @Route("/books/{isbn}", methods={"GET"})
     * @param string $isbn
     * @return JsonResponse
     */
    public function get(string $isbn): JsonResponse
    {
        $book = $this->finder->find($isbn);

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
        $books =$this->allFinder->findAll();

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

        try {

            $this->creator->create($isbn, $title, $author);

        } catch (BookAlreadyExists $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                    'status' => Response::HTTP_BAD_REQUEST
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

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

        try {

            $this->updater->update($isbn, $title, $author);

        } catch (BookNotExist $exception) {
            return new JsonResponse(
                [
                    'error' => "Book with isbn " . $isbn . " does not exist.",
                    "status" => Response::HTTP_NOT_FOUND,
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (BookAlreadyExists $exception) {
            return new JsonResponse(
                [
                'error' => $exception->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/books/{isbn}", methods={"DELETE"})
     * @param string $isbn
     * @return Response
     */
    public function remove(string $isbn): Response
    {
        try {

            $this->remover->remove($isbn);

        } catch (BookNotExist $exception) {
            return new JsonResponse(
                [
                    'error' => "Book with isbn " . $isbn . " does not exist.",
                    "status" => Response::HTTP_NOT_FOUND,
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return new Response('', Response::HTTP_OK);
    }

}