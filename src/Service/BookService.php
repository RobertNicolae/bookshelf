<?php


namespace App\Service;


use App\Exception\BookDescriptionInvalidException;
use App\Exception\BookNameInvalidException;
use App\Exception\BookNotFoundException;
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

        $this->bookRepo->insertBook(
            $bookFormParams->get("book_name"),
            $bookFormParams->get("book_description"),
            $bookFormParams->get("isbn"),
            $bookFormParams->get("total_pages"),
            $bookFormParams->get("cover_image"),
            $bookFormParams->get("publisher"),
            $bookFormParams->get("authors"),
        );
    }

    public function deleteBook(int $id): void
    {
        $book = $this->bookRepo->findById($id);

        if (!$book) {
            throw new BookNotFoundException();
        }

        $this->bookRepo->deleteBook($id);
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