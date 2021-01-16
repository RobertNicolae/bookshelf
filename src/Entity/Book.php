<?php


namespace App\Entity;


class Book
{
    /**
     * @var int
     */
    protected int $id;
    /**
     * @var string
     */
    protected string $name;
    /**
     * @var User
     */
    protected User $user;
    /**
     * @var Publisher
     */
    protected Publisher $publisher;
    /**
     * @var array
     */
    protected array $authors;
    /**
     * @var string
     */
    protected string $isbn;
    /**
     * @var int
     */
    protected int $totalPages;
    /**
     * @var string
     */
    protected string $coverImage;
    /**
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Book
     */
    public function setUser(User $user): Book
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Publisher
     */
    public function getPublisher(): Publisher
    {
        return $this->publisher;
    }

    /**
     * @param Publisher $publisher
     * @return Book
     */
    public function setPublisher(Publisher $publisher): Book
    {
        $this->publisher = $publisher;
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
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param array $authors
     * @return Book
     */
    public function setAuthors(array $authors): Book
    {
        $this->authors = $authors;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Book
     */
    public function setDescription(?string $description): Book
    {
        $this->description = $description;
        return $this;
    }


}