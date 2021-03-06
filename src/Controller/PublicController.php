<?php


namespace App\Controller;


use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class PublicController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render("public/welcome.html.twig", [
            "user" => $request->getSession()->get('user')
        ]);
    }

    public function test(Request $request): Response
    {

        return $this->render("base.html.twig", [
            'nickname' => $request->getRequestParams()->get('name')
        ]);

    }

}
