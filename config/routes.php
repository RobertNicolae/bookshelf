<?php


use App\Controller\BookController;
use App\Controller\PublicController;

$routes = [
    [
        'path' => '/',
        'controller' => PublicController::class,
        'method' => "GET",
        'function' => "index"
    ],
    [
        'path' => '/test',
        'controller' => PublicController::class,
        'method' => "GET",
        'function' => "test"
    ],
    [
        'path' => '/books',
        'controller' => BookController::class,
        'method' => "GET",
        'function' => "showBooks"
    ],
    [
        'path' => '/books/add',
        'controller' => BookController::class,
        'method' => ["GET", "POST"],
        'function' => "addBook"
    ],
    [
        'path' => '/books/delete',
        'controller' => BookController::class,
        'method' => ["GET"],
        'function' => "deleteBook"
    ],
];