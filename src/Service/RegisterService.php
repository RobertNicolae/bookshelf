<?php


namespace App\Service;


use App\Exception\LoginInvalidCredentialsException;
use App\Repository\UserRepository;

class RegisterService
{
    protected UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function register(string $email, string $password)
    {
        $inputPassword = sha1($password);
        $user = $this->userRepo->findByEmail($email);

        if($user) {
            throw new LoginInvalidCredentialsException();
        }
        if(empty(trim($email)) || empty(trim($password))){
            throw new LoginInvalidCredentialsException();
        }
            $this->userRepo->register($email, $inputPassword);
    }
}