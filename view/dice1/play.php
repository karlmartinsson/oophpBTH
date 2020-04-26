<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

//Show incoming variables and view helper functions
//var_dump($di);
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$game = $app->session->get("dice-game");

$player = $game->showPlayer();

$opponents = $game->showOpponents();

$winmessage = null;

if ($game->isGameWon()) {
    if ($game->isGameWon()->getId() === "you") {
        $winmessage = "Grattis! Du vann spelet med " . $game->isGameWon()->showPoints() . " poäng";
    } else {
        $winmessage = "Slut! Motståndare " . $game->isGameWon()->getId() . " vann spelet med "  . $game->isGameWon()->showPoints() . " poäng";
    }
}

?>
<h1 class="dicegame">Tärningsspelet</h1>



<?= $winmessage ? $winmessage : null ?>

<p><a href="../dice1" class="button">Starta om</a> </p>

<div class="dice-game-container">
<div class="dice-game-player">

<h2 class="dicegame">Du, Poäng: <?= $player->showPoints() ?></h2>
<div class="dice-game-player-content">
<p class="dicegame">Osparade poäng: <?= $player->showUnsavedPoints() ?></p>

<?= count($player->showLastThrows()) > 0 ? "<p class='dicegame'>Kastat den här omgången:</p>" : null ?>


<?php foreach ($player->showLastThrows() as $key => $throw) : ?>
    <div class="dice-game-dice-hand"> 
    <?php foreach ($throw as $dicevalue) : ?>
        <i class="dice-sprite dice-<?= $dicevalue ?>"></i>
    <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<p><a href="roll" class="button">Kasta tärning(ar)</a> <a href="save" class="button">Spara poäng</a></p>
    </div>
</div>

<?php foreach ($opponents as $key => $value) : ?>
    <div class="dice-game-player">
    <h2 class="dicegame">Motståndare <?= $key + 1 ?>, Poäng: <?= $value->showPoints() ?> </h2>
    <div class="dice-game-player-content">
    <?= count($value->showLastThrows()) > 0 ? " <p class='dicegame'>Sparat senaste omgången: " . $value->showLastSavedPoints() . "</p><p class='dicegame'>Kastat senaste omgången:</p>" : null ?>

    <?php foreach ($value->showLastThrows() as $key => $throw) : ?>
        <div class="dice-game-dice-hand"> 
        <?php foreach ($throw as $dicevalue) : ?>
            <i class="dice-sprite dice-<?= $dicevalue ?>"></i>
        <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </div>
        </div>
<?php endforeach; ?>


<div class="dice-game-player histogram">
    <h2 class="dicegame">Histogram över spelet:</h2>
    <div class="dice-game-player-content">
<?= $game->printHistogram(1, 6) ?>
        </div>
        </div>
        </div>





