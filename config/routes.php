<?php


use App\Controller\AuthorController;
use App\Controller\BookController;
use App\Controller\LoginController;
use App\Controller\PublicController;
use App\Controller\PublisherController;

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
    [
        'path' => '/authors',
        'controller' => AuthorController::class,
        'method' => ["GET"],
        'function' => "showAuthors"
    ],
    [
        'path' => '/authors/add',
        'controller' => AuthorController::class,
        'method' => ["GET", "POST"],
        'function' => "addAuthor"
    ],
    [
        'path' => '/authors/delete',
        'controller' => AuthorController::class,
        'method' => ["GET"],
        'function' => "deleteAuthor"
    ],
    [
        'path' => '/authors/edit',
        'controller' => AuthorController::class,
        'method' => ["GET", "POST"],
        'function' => "editAuthor"
    ],
    [
        'path' => '/publishers',
        'controller' => PublisherController::class,
        'method' => ["GET"],
        'function' => "showPublishers"
    ],
    [
        'path' => '/publisher/add',
        'controller' => PublisherController::class,
        'method' => ["GET", "POST"],
        'function' => "addPublisher"
    ],
    [
        'path' => '/publisher/delete',
        'controller' => PublisherController::class,
        'method' => ["GET"],
        'function' => "deletePublisher"
    ],
    [
        'path' => '/publisher/edit',
        'controller' => PublisherController::class,
        'method' => ["GET", "POST"],
        'function' => "editPublisher"
    ],
    [
        'path' => '/login',
        'controller' => LoginController::class,
        'method' => ["GET", "POST"],
        'function' => "login"
    ],
    [
        'path' => '/login/welcome',
        'controller' => LoginController::class,
        'method' => ["GET", "POST"],
        'function' => "welcome"
    ],
];