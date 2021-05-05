<?php


namespace App\Repository;


use App\Builder\PublisherBuilder;
use App\Entity\Publisher;
use LightFramework\Database\DatabaseConnection;

class PublisherRepository
{
    protected \PDO $connection;
    protected PublisherBuilder $publisherBuilder;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->publisherBuilder = new PublisherBuilder();
    }


    public function findAll(): array
    {
        $query = "SELECT p.name AS publisher_name, p.id AS publisher_id from publisher as p;";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $publishers = [];
        foreach ($result as $publisher) {
            $publishers[] = $this->mapDataOnEntity($publisher);
        }

        return $publishers;
    }
    public function findById(int $id):  ?Publisher
    {
        $query = "SELECT p.id as publisher_id, p.name as publisher_name FROM publisher p WHERE p.id = :id";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([":id" => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? $this->mapDataOnEntity($result) : null;
    }
    public function addPublisher(string $name): void
    {
        $query = "INSERT INTO publisher (name) VALUES (:name)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
           "name" => $name
        ]);
    }

    public function deletePublisher(int $id): void
    {
        $query = "DELETE FROM publisher WHERE id = :id";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ":id" => $id,
        ]);
    }
    public function update(int $id, string $name): void
    {
        $query = "UPDATE publisher p SET p.name = :name WHERE p.id= :id;";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            ":id" => $id,
            ":name" => $name,
        ]);

    }

    protected function mapDataOnEntity(array $rowdata): Publisher
    {
        return $this->publisherBuilder->getPublisher($rowdata["publisher_id"], $rowdata["publisher_name"]);
    }
}