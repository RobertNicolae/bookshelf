<?php


namespace LightFramework\Http;

use LightFramework\Http\Exception\RouteNotFoundException;

/**
 * TODO: to upgrade
 *
 * Class Router
 * @package ChristianFramework\HttpModule
 */
class Router
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var array
     */
    private array $routes;

    /**
     * @var string[]
     */
    public static array $supportedHttpMethods = [
        "GET",
        "POST"
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return Router
     */
    public function setRoutes(array $routes): Router
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * @return Response
     * @throws RouteNotFoundException
     */
    public function handle()
    {
        $currentRoute = null;
        $formatedRoute = $this->formatRoute($this->request->getServerParams()->get("REDIRECT_URL"));
        if ($formatedRoute) {
            foreach ($this->routes as $route) {
                if ($route["path"] === $formatedRoute) {
                    $currentRoute = $route;
                }
            }
        }

        if (!$currentRoute) {
            throw new RouteNotFoundException();
        }

        $route = $currentRoute['path'];
        $controller = $currentRoute['controller'];
        $method = $currentRoute['function'];

        if (is_array($currentRoute['method'])) {
            if (in_array($this->request->getServerParams()->get("REQUEST_METHOD"), $currentRoute['method'])) {
                $currentRoute['method'] = $this->request->getServerParams()->get("REQUEST_METHOD");
            }
        }

        if (!in_array(strtoupper($currentRoute['method']), self::$supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }
        $this->{strtolower($currentRoute['method'])}[$this->formatRoute($route)] = [
            'controller' => $controller,
            'method' => $method
        ];

        return $this->resolve();
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->getServerParams()->get('SERVER_PROTOCOL')} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->getServerParams()->get('SERVER_PROTOCOL')} 404 Not Found");
    }

    public function resolve(): Response
    {
        $methodDictionary = $this->{strtolower($this->request->getServerParams()->get("REQUEST_METHOD"))};
        $formatedRoute = $this->formatRoute($this->request->getServerParams()->get("REDIRECT_URL") ? $this->request->getServerParams()->get("REDIRECT_URL") : '/');

        $controller = $methodDictionary[$formatedRoute]['controller'];
        $method = $methodDictionary[$formatedRoute]['method'];

        if (is_null($method)) {
            throw new \Exception("Method not found");
        }

        $controllerInstance = new $controller();

        return $controllerInstance->$method($this->request);
    }
}