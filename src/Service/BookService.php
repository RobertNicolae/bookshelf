<?php


namespace App\Service;


use App\Exception\BookDescriptionInvalidException;
use App\Exception\BookNameInvalidException;
use App\Repository\BookRepository;
use LightFramework\DataStructure\ArrayCollection;

class BookService
{
    protected BookRepository $bookRepo;

    public function __construct()
    {
        $this->bookRepo = new BookRepository();
    }

    /**\
     * @param ArrayCollection $bookFormParams
     * @throws BookDescriptionInvalidException
     * @throws BookNameInvalidException
     */
    public function addBookFromForm(ArrayCollection $bookFormParams): void
    {
        $this->validateDataForBook($bookFormParams);

        $this->bookRepo->insertBook($bookFormParams->get("book_name"), $bookFormParams->get("book_description"));
    }

    /**
     * @param ArrayCollection $bookFormParams
     * @throws BookDescriptionInvalidException
     * @throws BookNameInvalidException
     */
    protected function validateDataForBook(ArrayCollection $bookFormParams): void
    {
        if (!$bookFormParams->get("book_name")) {
            throw new BookNameInvalidException();
        }
        if (!$bookFormParams->get("book_description")) {
            throw new BookDescriptionInvalidException();
        }
    }
}