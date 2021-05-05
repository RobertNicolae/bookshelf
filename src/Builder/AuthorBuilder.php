<?php


namespace App\Builder;


use App\Entity\Author;

class AuthorBuilder
{
    public function getAuthor(int $id, string $name): Author
    {
        $author = new Author();

        $author->setId($id)
            ->setName($name);

        return $author;
    }
}