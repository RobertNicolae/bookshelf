<?php


namespace App\Service;


use App\Exception\PublisherInvalidNameException;
use App\Repository\PublisherRepository;
use LightFramework\DataStructure\ArrayCollection;

class PublisherService
{
    protected PublisherRepository $publisherRepo;


    public function __construct()
    {
        $this->publisherRepo = new PublisherRepository();
    }

    public function addPublisherFromForm(ArrayCollection $params): void
    {
        if (!$params->get("publisher_name")) {
            throw new PublisherInvalidNameException();
        }
        $this->publisherRepo->addPublisher($params->get("publisher_name"));
    }
    public function deletePublisher(int $id): void
    {
        $this->publisherRepo->findById($id);
        $this->publisherRepo->deletePublisher($id);

    }
    public function editPublisher(ArrayCollection $params): void
    {
        if(!$params->get("publisher_name")){
            throw new PublisherInvalidNameException();
        }
        $this->publisherRepo->update($params->get("id"), $params->get("publisher_name"));

    }


}