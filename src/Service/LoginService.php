<?php


namespace App\Service;


use App\Entity\User;
use App\Exception\AuthorInvalidNameException;
use App\Exception\LoginInvalidCredentialsException;
use App\Repository\LoginRepository;
use LightFramework\DataStructure\ArrayCollection;

class LoginService
{
    protected LoginRepository $loginRepo;
    public function __construct(){
        $this->loginRepo = new LoginRepository();
    }

    public function logout(): void
    {
        session_start();
        unset($_SESSION["id"]);
        unset($_SESSION["email"]);
        $_SESSION["loggedin"] = false;
        header("Location:/login");
    }
    public function login(ArrayCollection $params): void
    {
        $result = $this->loginRepo->login($params->get("email"), $params->get("password"));

        if ($result === null) {
            throw new LoginInvalidCredentialsException();
        }

    }

    public function setUserSession(int $id, string $email): void
    {
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["email"] = $email;
    }
}