<?php


namespace App\Service;


use App\Entity\Author;
use App\Exception\AuthorInvalidNameException;
use App\Exception\BookDescriptionInvalidException;
use App\Exception\BookNameInvalidException;
use App\Exception\BookNotFoundException;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use LightFramework\DataStructure\ArrayCollection;

class AuthorService
{
    protected AuthorRepository $authorRepo;

    public function __construct()
    {
        $this->authorRepo = new AuthorRepository();
    }

    /**
     * @param ArrayCollection $params
     * @throws AuthorInvalidNameException
     */
    public function addAuthorFromForm(ArrayCollection $params): void
    {
        if (!$params->get("author_name")) {
            throw new AuthorInvalidNameException();
        }
        $this->authorRepo->insertAuthor($params->get("author_name"));
    }

    public function deleteAuthor(int $id): void
    {
        $this->authorRepo->findById($id);
        $this->authorRepo->deleteAuthor($id);
        header("/authors");
    }

    public function editAuthor(int $id, string $name): void
    {
        $this->authorRepo->findById($id);
        $this->authorRepo->update($id, $name);
        header("/authors");
    }
}