<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


$app->router->get("dice-game", function () use ($app) {
    $title = "Tärningsspelet";

    $app->page->add("dice/start");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Init the game and redirect to play the game
 */
$app->router->post("dice/init", function () use ($app) {
    $_SESSION["dice-game"] = new Karl\Dice\DiceGame($_POST["opponents"], $_POST["dices"]);
    return $app->response->redirect("dice/play");
});



/**
 * Play the game.
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";

    $app->page->add("dice/play");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/roll", function () use ($app) {
    $_SESSION["dice-game"]->play(true);
    return $app->response->redirect("dice/play");
});

/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/save", function () use ($app) {
    $_SESSION["dice-game"]->play(false);
    return $app->response->redirect("dice/play");
});


// /**
//  * Make a guess.
//  */
// $app->router->post("guess/make-guess", function () use ($app) {
    

//     $game = $_SESSION["game"];
//     $_SESSION["guess-data"] = $_POST;

//     try {
//         $_SESSION["result"] = $game->makeGuess(intval($_SESSION["guess-data"]["number"]));
//     } catch (Karl\Guess\GuessException $e) {
//         $_SESSION["exception"] = "Din gissning måste vara ett nummer mellan 1 och 100";
//     } 

//     return $app->response->redirect("guess/play");
// });
