<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

/**
 * Routes to ease testing.
 */
return [
    // All routes in order
    "routes" => [
        [
            "info" => "Movie database",
            "mount" => "movie",
            "handler" => "\Karl\Movie\MovieController",
        ],
    ]
];
