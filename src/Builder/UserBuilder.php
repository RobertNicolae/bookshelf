<?php


namespace App\Builder;


use App\Entity\User;

class UserBuilder
{
    public function getUser(int $id, string $email, string $password, int $role, \DateTime $dateTime): User
    {
        $user = new User();
        $user
            ->setId($id)
            ->setCreated($dateTime)
            ->setRole($role)
            ->setPassword($password)
            ->setEmail($email);

        return $user;
    }
}