<?php


namespace App\Repository;


use App\Builder\AuthorBuilder;
use App\Entity\Author;
use App\Entity\Book;
use LightFramework\Database\DatabaseConnection;

class AuthorRepository
{
    protected \PDO $connection;
    protected AuthorBuilder $authorBuilder;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->authorBuilder = new AuthorBuilder();
    }

    /**
     * @return Author[]
     */
    public function findAll(): array
    {
        $query = "SELECT a.name AS author_name, a.id AS author_id from author as a";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $authors = [];
        foreach ($result as $res) {
            $authors[] = $this->mapDataOnEntity($res);
        }
        return $authors;
    }

    public function findById(int $id): ?Author
    {
        $query = "SELECT a.id as author_id, a.name as author_name FROM author a WHERE a.id = :id";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([":id" => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? $this->mapDataOnEntity($result) : null;

    }

    public function insertAuthor(string $name): void
    {
        $query = "INSERT INTO author (name) VALUES (:name )";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ":name" => $name
        ]);
    }

    public function deleteAuthor(int $id): void
    {
        $query = "DELETE FROM author WHERE id = :id";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ":id" => $id,
        ]);
    }

    public function update(int $id, string $name): void
    {
        $query = "UPDATE author a SET a.name = :name WHERE a.id= :id;";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ":id" => $id,
            ":name" => $name,
        ]);

    }

    protected function mapDataOnEntity(array $rowData): Author
    {
        return $this->authorBuilder->getAuthor($rowData["author_id"], $rowData["author_name"]);

    }


}