<?php
/**
 * Just display some nice message to see it all works.
 */

include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");



if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
    $game = $_SESSION["game"];
    $game->random();
} else {
    $game = $_SESSION["game"];
}




//echo $game->makeGuess(98);

//echo $game->number();

include(__DIR__ . "/view/game.php");
$_SESSION["exception"] = null;
