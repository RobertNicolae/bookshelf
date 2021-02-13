<?php


namespace App\Controller;


use App\Exception\LoginInvalidCredentialsException;
use App\Service\LoginService;
use App\Service\RegisterService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class LoginController extends AbstractController
{
    protected LoginService $loginService;
    protected RegisterService $registerService;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->registerService = new RegisterService();
    }

    public function register(Request $request): Response
    {
        $errors = [];
        if ($request->isMethod(Request::METHOD_POST)){

            try {
                $this->registerService->register($request->getRequestParams()->get("email"), $request->getRequestParams()->get("password"));
            } catch (LoginInvalidCredentialsException $exception) {
                $errors["credentials"] = "Exista deja un cont cu aceste credentiale sau nu sunt introduse date";
            }
            if (empty($errors)) {
                header("Location: /login");
                die();
            }
        }

       return $this->render("register/register_form.html.twig", [
           "errors" => $errors
       ]);

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




