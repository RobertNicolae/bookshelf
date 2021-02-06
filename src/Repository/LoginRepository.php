<?php


namespace App\Repository;


use App\Builder\UserBuilder;
use App\Entity\Publisher;
use App\Entity\User;
use LightFramework\Database\DatabaseConnection;

class LoginRepository
{
    protected \PDO $connection;
    protected UserBuilder $userBuilder;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->userBuilder = new UserBuilder();
    }

    public function login(string $email, string $password): ?User
    {
        $query = "SELECT * from user u WHERE u.email = :email AND u.password = :password; ";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([
            "email" => $email,
            "password" => $password
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result !== false ? $this->mapDataOnEntity($result) : null;
    }

    protected function mapDataOnEntity(array $rowData): User
    {
        return $this->userBuilder->getUser($rowData["id"], $rowData["email"], $rowData["password"], $rowData["role"], \DateTime::createFromFormat("Y-m-d H:i:s",$rowData["created"]));
    }
}