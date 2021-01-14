<?php


namespace App\Controller;


use App\Exception\BookDescriptionInvalidException;
use App\Exception\BookNameInvalidException;
use App\Repository\BookRepository;
use App\Service\BookService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class BookController extends AbstractController
{
    protected BookRepository $bookRepo;
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookRepo = new BookRepository();
        $this->bookService = new BookService();
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
        return $this->render('book/form.html.twig');
    }
}