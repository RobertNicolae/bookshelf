<?php


namespace App\Repository;


use App\Builder\AuthorBuilder;
use App\Builder\PublisherBuilder;
use App\Builder\UserBuilder;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use LightFramework\Database\DatabaseConnection;

class BookRepository
{
    protected \PDO $conn;
    protected UserBuilder $userBuilder;
    protected AuthorBuilder $authorBuilder;
    protected PublisherBuilder $publisherBuilder;

    public function __construct()
    {
        $this->conn = DatabaseConnection::getConnection();
        $this->userBuilder = new UserBuilder();
        $this->authorBuilder = new AuthorBuilder();
        $this->publisherBuilder = new PublisherBuilder();
    }

    /**
     * @return Book[]
     */
    public function findAll(): array
    {
        $query = $this->selectQueryForBook();

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $books = [];
        foreach ($result as $item) {
            $books[] = $this->mapDataOnEntity($item);
        }

        return $books;
    }

    /**
     * @param int $id
     * @return Book|null
     */
    public function findById(int $id): ?Book
    {
        $query = $this->selectQueryForBook("WHERE b.id = :id");

        $stmt = $this->conn->prepare($query);
        $stmt->execute([":id" => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? $this->mapDataOnEntity($result) : null;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $isbn
     * @param int $totalPages
     * @param string $coverImage
     * @param int $publisherId
     * @param int[] $authorsIds
     */
    public function insertBook(string $name, string $description, string $isbn, int $totalPages, string $coverImage, int $publisherId, array $authorsIds): void
    {
        $query = "INSERT INTO book (name, description, isbn, total_pages, publisher_id, cover_image, user_id) VALUES (:name, :description, :isbn, :total_pages, :publisher_id, :cover_image, :user_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ":name" => $name,
            ":description" => $description,
            ":isbn" => $isbn,
            ":total_pages" => $totalPages,
            ":publisher_id" => $publisherId,
            ":cover_image" => $coverImage,
            ":user_id" => $_SESSION['user']->getId()
        ]);

        $bookId = $this->conn->lastInsertId();

        $query = "INSERT INTO author_book(author_id, book_id) VALUES ";

        foreach ($authorsIds as $authorId) {
            $query .= "(" . $authorId . "," . $bookId . "), ";
        }
        $query = rtrim($query, ", ");

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

    public function deleteBook(int $id): void
    {
        $query = "DELETE FROM book WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ":id" => $id,
        ]);
    }

    public function findAllByAuthor(Author $author): array
    {
        $query = $this->selectQueryForBook("WHERE a.id = :authorId");

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ":authorId" => $author->getId()
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $books = [];
        foreach ($result as $item) {
            $books[] = $this->mapDataOnEntity($item);
        }

        return $books;
    }

    protected function selectQueryForBook(?string $whereClause = null): string
    {
        return "SELECT b.name                          AS book_name,
       b.id                            AS book_id,
       b.description                   AS book_description,
       b.isbn                          AS book_isbn,
       b.total_pages                   AS book_total_pages,
       b.cover_image                   AS book_cover_image,
       u.id                            AS user_id,
       u.email                         AS user_email,
       u.password                      AS user_password,
       u.role                          AS user_role,
       u.created                       AS user_created,
       p.id                            AS publisher_id,
       p.name                          AS publisher_name,
       GROUP_CONCAT(a.id, '/', a.name) AS authors
FROM book AS b
         LEFT JOIN publisher AS p on b.publisher_id = p.id
         LEFT JOIN user AS u on b.user_id = u.id
         LEFT JOIN author_book ab on b.id = ab.book_id
         LEFT JOIN author a on ab.author_id = a.id
 " . $whereClause . " 
GROUP BY b.id";
    }

    protected function mapDataOnEntity(array $rowData): Book
    {
        $book = new Book();

        $user = $this->userBuilder->getUser(
            $rowData['user_id'],
            $rowData['user_email'],
            $rowData['user_password'],
            $rowData['user_role'],
            \DateTime::createFromFormat("Y-m-d H:i:s", $rowData['user_created'])
        );
        $authors = [];
        if (isset($rowData["authors"])) {

            $authorStringsArr = explode(",", $rowData['authors']);

            foreach ($authorStringsArr as $authorStringArr) {
                list($authorId, $authorName) = explode('/', $authorStringArr);

                $author = $this->authorBuilder->getAuthor($authorId, $authorName);
                $authors[] = $author;
            }
        }


        $publisher = $this->publisherBuilder->getPublisher($rowData['publisher_id'], $rowData['publisher_name']);

        //TODO: De mutat logica de creeare book in BookBuilder
        $book
            ->setId($rowData["book_id"])
            ->setName($rowData["book_name"])
            ->setDescription($rowData["book_description"])
            ->setIsbn($rowData['book_isbn'])
            ->setTotalPages($rowData['book_total_pages'])
            ->setCoverImage($rowData['book_cover_image'])
            ->setUser($user)
            ->setAuthors($authors)
            ->setPublisher($publisher);

        return $book;
    }
}