<?php


namespace App\Controller;


use App\Exception\AuthorInvalidNameException;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Service\AuthorService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class AuthorController extends AbstractController
{
    protected AuthorRepository $authorRepo;
    protected BookRepository $bookRepo;
    protected AuthorService $authorService;

    public function __construct()
    {
        $this->authorRepo = new AuthorRepository();
        $this->bookRepo = new BookRepository();
        $this->authorService = new AuthorService();
    }


    public function showAuthors(Request $request): Response
    {
        $authors = $this->authorRepo->findAll();
        $booksByAuthor = [];
        foreach ($authors as $author) {
            $booksByAuthor[$author->getId()] = $this->bookRepo->findAllByAuthor($author);
        }

        return $this->render('author/authors.html.twig', [
            "authors" => $this->authorRepo->findAll(),
            "booksByAuthor" => $booksByAuthor
        ]);
    }

    public function addAuthor(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $errors = [];
            try {
                $this->authorService->addAuthorFromForm($request->getRequestParams());
            } catch (AuthorInvalidNameException $exception) {
                $errors["author_name"] = "Nume invalid";
            }
            if (!empty($errors)) {
                return $this->render('author/form.html.twig', [
                    "errors" => $errors
                ]);
            }

            header("Location: /authors");
            die;
        }
        return $this->render('author/form.html.twig');
    }

    public function deleteAuthor(Request $request): void
    {
        $this->authorService->deleteAuthor($request->getRequestParams()->get("id"));
        header("Location: /authors");
        die();

    }

    public function editAuthor(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
        $this->authorRepo->update($request->getRequestParams()->get("id"), $request->getRequestParams()->get("author_name"));
        header("Location: /authors");
        die();

        }
         return $this->render('author/form_edit.html.twig', [
             "author" =>  $this->authorRepo->findById($request->getRequestParams()->get("id"))
         ]);
    }
}
