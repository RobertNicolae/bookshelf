<?php


namespace App\Controller;


use App\Service\LoginService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class LoginController extends AbstractController
{
    protected LoginService $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function login(Request $request): Response
    {
        if (isset($_SESSION["user"])) {
            header("location: /");
            exit;
        }

        $errors = [];
        if ($request->isMethod(Request::METHOD_POST)) {
            try {
                $this->loginService->login($request->getRequestParams()->get("email"), $request->getRequestParams()->get("password"));
            } catch (\Exception $exception) {
                $errors["credentials"] = "Username or password invalid";
            }

            if (empty($errors)) {
                header("Location: /");
                die();
            }
        }

        return $this->render("login/login_form.html.twig", [
            "errors" => $errors
        ]);
    }

    public function logout(Request $request)
    {
        $this->loginService->logout();
        header("Location:/login");
    }
}




