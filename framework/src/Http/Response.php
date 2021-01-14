<?php


namespace LightFramework\Http;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Response
{
    protected FilesystemLoader $loader;

    protected Environment $twig;

    protected string $pathToTemplate;

    protected array $params;

    public function __construct(string $pathToTemplate, array $params = [])
    {
        $this->loader = new FilesystemLoader(__DIR__ . "/../../../templates");

        $options = [
            'strict_variables' => false,
            'debug' => false,
            'cache' => false
        ];

        $this->twig = new Environment($this->loader, $options);

        $this->pathToTemplate = $pathToTemplate;
        $this->params = $params;
    }

    public function render(): void
    {
        echo $this->twig->render($this->pathToTemplate, $this->params);
        die;
    }
}