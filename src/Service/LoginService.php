<?php


namespace App\Service;


use App\Entity\User;
use App\Exception\LoginInvalidCredentialsException;
use App\Repository\UserRepository;
use LightFramework\DataStructure\ArrayCollection;

class LoginService
{
    protected UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function logout(): void
    {
        unset($_SESSION["user"]);
    }

    public function login(string $email, string $inputPassword): void
    {
        $user = $this->userRepo->findByEmail($email);

        if (!$user) {
            throw new LoginInvalidCredentialsException();
        }

        if ($user->getPassword() !== sha1($inputPassword)) {
            throw new LoginInvalidCredentialsException();
        }

        $this->setUserSession($user);
    }

    protected function setUserSession(User $user): void
    {
        $_SESSION["user"] = $user;
    }
}