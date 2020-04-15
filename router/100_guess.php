<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start";
    $_SESSION["guess-data"] = null;
    $_SESSION["result"] = null;
    $game = new Karl\Guess\Guess();
    $game->random();
    $_SESSION["game"] = $game;
    return $app->response->redirect("guess/play");
});



/**
 * Play the game.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    $app->page->add("guess/play");
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Make a guess.
 */
$app->router->post("guess/make-guess", function () use ($app) {
    

    $game = $_SESSION["game"];
    $_SESSION["guess-data"] = $_POST;

    try {
        $_SESSION["result"] = $game->makeGuess(intval($_SESSION["guess-data"]["number"]));
    } catch (Karl\Guess\GuessException $e) {
        $_SESSION["exception"] = "Din gissning måste vara ett nummer mellan 1 och 100";
    } 

    return $app->response->redirect("guess/play");
});