<?php


namespace App\Builder;


use App\Entity\Publisher;

class PublisherBuilder
{
    public function getPublisher(int $id, string $name): Publisher
    {
        $publisher = new Publisher();

        $publisher->setId($id)
            ->setName($name);

        return $publisher;
    }
}