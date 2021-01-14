<?php

use LightFramework\Http\Kernel;
use LightFramework\Http\Request;

require dirname(__DIR__) . '/config/bootstrap.php';
foreach (file(dirname(__DIR__) . '/.env') as $line) {
    $envVar = explode('=', trim($line), 2);
    $_ENV[$envVar[0]] = $envVar[1];
}

if (!isset($_ENV["APP_MODE"])) {
    throw new Exception("App mode is not set");
}
if ($_ENV["APP_MODE"] === "DEV") {
    ini_set("display_errors", true);
}

session_start();


$request = Request::createFromGlobals();

$kernel = new Kernel($request);
$response = $kernel->handle();
$response->render();

