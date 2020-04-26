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
            "info" => "Tärningsspelet",
            "mount" => "dice1",
            "handler" => "\Karl\Dice1\DiceController",
        ],
    ]
];
