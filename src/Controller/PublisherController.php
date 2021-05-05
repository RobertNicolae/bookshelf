<?php


namespace App\Controller;


use App\Builder\PublisherBuilder;
use App\Entity\Publisher;
use App\Exception\PublisherInvalidNameException;
use App\Repository\PublisherRepository;
use App\Service\PublisherService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class PublisherController extends AbstractController
{

    protected PublisherBuilder $publisherBuilder;
    protected PublisherRepository $publisherRepo;
    protected PublisherService $publisherService;

    public function __construct()
    {
        $this->publisherRepo = new PublisherRepository();
        $this->publisherBuilder = new PublisherBuilder();
        $this->publisherService = new PublisherService();
    }


    public function showPublishers(Request $request): Response
    {

        return $this->render('publisher/show.html.twig', [
            "publishers" => $this->publisherRepo->findAll()
        ]);


    }

    public function addPublisher(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $errors = [];
            try {
                $this->publisherService->addPublisherFromForm($request->getRequestParams());
            } catch (PublisherInvalidNameException $exception) {
                $errors['publisher_name'] = "Nume invalid";
            }
            if (!empty($errors)) {
                return $this->render('publisher/form.html.twig', [
                    "errors" => $errors
                ]);
            }
            header("Location: /publishers");
            die;
        }
        return $this->render('publisher/form.html.twig');
    }

    public function deletePublisher(Request $request): Response
    {

        $this->publisherService->deletePublisher($request->getRequestParams()->get("id"));
        header("Location: /publishers");
        die();
    }

    public function editPublisher(Request $request): Response
    {
        $errors = [];
        if ($request->isMethod(Request::METHOD_POST)) {#

            try {
                $this->publisherService->editPublisher($request->getRequestParams());
            } catch (PublisherInvalidNameException $exception) {
                $errors["publisher_name"] = "Nume invalid";
            }

            if (empty($errors)) {
                header("Location: /publishers");
                die();
            }


        }
        return $this->render('publisher/form_edit.html.twig', [
            "publisher" => $this->publisherRepo->findById($request->getRequestParams()->get("id")),
            "errors" => $errors
        ]);
    }
}