<?php


namespace LightFramework\Controller;


use LightFramework\Http\Response;

abstract class AbstractController
{
    protected function render(string $pathToTemplate, array $params = []): Response {
        return new Response($pathToTemplate, $params);
    }
}