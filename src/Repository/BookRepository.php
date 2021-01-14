<?php


namespace App\Repository;


use App\Entity\Book;
use LightFramework\Database\DatabaseConnection;

class BookRepository
{
    protected \PDO $conn;

    public function __construct()
    {
        $this->conn = DatabaseConnection::getConnection();
    }

    /**
     * @return Book[]
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM book";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $books = [];
        foreach ($result as $item) {
            $books[] = $this->mapDataOnEntity($item);
        }

        return $books;
    }

    public function insertBook(string $name, string $description): void
    {
        $query = "INSERT INTO book (name, description) VALUES (:name, :description)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ":name" => $name,
            ":description" => $description
        ]);
    }

    protected function mapDataOnEntity(array $rowData): Book
    {
        $book = new Book();

        $book
            ->setId($rowData["id"])
            ->setName($rowData["name"])
            ->setDescription($rowData["description"])
            ->setCreated(\DateTime::createFromFormat("Y-m-d H:i:s", $rowData["created"]));

        return $book;
    }
}