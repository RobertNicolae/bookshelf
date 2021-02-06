<?php


namespace App\Controller;


use App\Entity\User;
use App\Exception\LoginInvalidCredentialsException;
use App\Repository\LoginRepository;
use App\Service\LoginService;
use LightFramework\Controller\AbstractController;
use LightFramework\Http\Request;
use LightFramework\Http\Response;

class LoginController extends AbstractController
{
    protected LoginRepository $loginRepo;
    protected LoginService $loginService;

    public function __construct()
    {
        $this->loginRepo = new LoginRepository();
        $this->loginService = new LoginService();
    }

    public function login(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST))
        {
            if (isset($_SESSION["id"]) && $_SESSION["loggedin"] === true) {
                header("location: /login/welcome");
                exit;
            }
            $result = $this->loginRepo->login($request->getRequestParams()->get("email"), $request->getRequestParams()->get("password"));
            $errors = [];
            if ($result !== null) {
                $this->loginService->setUserSession($result->getId(), $result->getEmail());
                header("Location: /login/welcome");
                die();
            } else {
                $errors["credentials"] = "Username or password invalid";
                return $this->render("login/login_form.html.twig", [
                    "errors" => $errors
                ]);
            }
        }
        return $this->render("login/login_form.html.twig");
    }
    public function welcome(Request $request): Response
    {
        if (!isset($_SESSION["id"]) && $_SESSION["loggedin"] === false) {
            throw new \Exception();
        }
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->loginService->logout();
            header("Location: /login");
            exit();
        }
        return $this->render("login/welcome.html.twig");
    }
}




