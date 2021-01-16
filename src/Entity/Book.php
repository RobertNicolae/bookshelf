<?php


namespace App\Entity;


class Book
{
    protected int $id;
    protected string $name;
    protected int $publisherId;
    protected int $userId;
    protected string $isbn;
    protected int $totalPages;
    protected string $coverImage;
    protected ?string $description = null;

    /**
     * @return int
     */
    public function getPublisherId(): int
    {
        return $this->publisherId;
    }

    /**
     * @param int $publisherId
     * @return Book
     */
    public function setPublisherId(int $publisherId): Book
    {
        $this->publisherId = $publisherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Book
     */
    public function setUserId(int $userId): Book
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     * @return Book
     */
    public function setTotalPages(int $totalPages): Book
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoverImage(): string
    {
        return $this->coverImage;
    }

    /**
     * @param string $coverImage
     * @return Book
     */
    public function setCoverImage(string $coverImage): Book
    {
        $this->coverImage = $coverImage;
        return $this;
    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Book
     */
    public function setName(string $name): Book
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Book
     */
    public function setDescription(string $description): Book
    {
        $this->description = $description;
        return $this;
    }


}