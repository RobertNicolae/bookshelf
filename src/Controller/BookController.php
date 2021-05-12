<?php


namespace App\Controller;


use App\Exception\BookDescriptionInvalidException;
use App\Exception\BookNameInvalidException;
use App\Exception\BookNotFoundException;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\PublisherRepository;
use App\Service\BookService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class BookController extends AbstractController
{
    protected BookRepository $bookRepo;
    protected BookService $bookService;
    protected PublisherRepository $publisherRepo;
    protected AuthorRepository $authorRepo;

    public function __construct()
    {
        $this->bookRepo = new BookRepository();
        $this->bookService = new BookService();
        $this->publisherRepo = new PublisherRepository();
        $this->authorRepo = new AuthorRepository();
    }

    public function showBooks(Request $request): Response
    {
        return $this->render('book/show.html.twig', [
            "books" => $this->bookRepo->findAll()
        ]);
    }

    public function addBook(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {

            $errors = [];
            try {
                $this->bookService->addBookFromForm($request->getRequestParams());
            } catch (BookNameInvalidException $exception) {
                $errors["book_name"] = "Book name invalid";
            } catch (BookDescriptionInvalidException $exception) {
                $errors["book_description"] = "Book description invalid";
            }

            if (!empty($errors)) {
                return $this->render('book/form.html.twig', [
                    "errors" => $errors
                ]);
            }

            header("Location: /books");
            die;
        }
        return $this->render('book/form.html.twig', [
            'publishers' => $this->publisherRepo->findAll(),
            'authors' => $this->authorRepo->findAll()
        ]);
    }

    public function deleteBook(Request $request): void
    {
        try {
            $this->bookService->deleteBook($request->getRequestParams()->get("id"));
        } catch (BookNotFoundException $bookNotFoundException) {
            echo "Cartea nu exista";
            exit;
        }

        header("Location: /books");
        die;
    }

    public function editBook(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {

            $this->bookRepo->update($request->getRequestParams()->get("id"), $request->getRequestParams()->get("book_name"), $request->getRequestParams()->get("book_description"), $request->getRequestParams()->get("isbn"), $request->getRequestParams()->get("total_pages"), $request->getRequestParams()->get("cover_image"), $request->getRequestParams()->get("publisher"), $request->getRequestParams()->get("authors"));
            header("Location: /books");
            die();

        }
        return $this->render('book/form_edit.html.twig', [
            "book" =>  $this->bookRepo->findById($request->getRequestParams()->get("id")),
            'publishers' => $this->publisherRepo->findAll(),
            'authors' => $this->authorRepo->findAll()
        ]);
    }
}