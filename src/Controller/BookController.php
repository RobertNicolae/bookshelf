<?php


namespace App\Controller;


use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class BookController extends AbstractController
{
    public function showBooks(Request $request): Response
    {

        return $this->render('book/show.html.twig');

    }
    public function addBook(Request $request): Response
    {

        return $this->render('book/form.html.twig');

    }
}