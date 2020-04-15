<?php

include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

$_SESSION["guess-data"] = $_POST;

$game = $_SESSION["game"];

try {
    $_SESSION["result"] = $game->makeGuess(intval($_SESSION["guess-data"]["number"]));
} catch (GuessException $e) {
    $_SESSION["exception"] = $e;
} 




// Redirect to index page.
$url = "index.php";
header("Location: $url");
