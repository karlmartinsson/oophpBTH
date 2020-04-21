<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$game = $_SESSION["dice-game"];

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

<p><a href="../dice-game" class="button">Starta om</a> <a href="roll" class="button">Spela</a> <a href="save" class="button">Spara poäng</a></p>
<h2 class="dicegame">Du</h2>


<p class="dicegame">Poäng: <?= $player->showPoints() ?></p>
<p class="dicegame">Osparade poäng: <?= $player->showUnsavedPoints() ?></p>
<?= count($player->showLastThrows()) > 0 ? "<p>Hittils kastat under omgången:</p>" : null ?>

<?php foreach ($player->showLastThrows() as $key => $throw) : ?>
    <span class="dicegame">Kast <?= $key + 1 ?>:</span> 
    <?php foreach ($throw as $dicevalue) : ?>
        <i class="dice-sprite dice-<?= $dicevalue ?>"></i>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php foreach ($opponents as $key => $value) : ?>
    <h2 class="dicegame">Motståndare <?= $key + 1 ?></h2>
    <p class="dicegame">Poäng: <?= $value->showPoints() ?> </p>
    <?= count($value->showLastThrows()) > 0 ? " <p>Motståndaren sparade " . $value->showLastSavedPoints() . " poäng på totalt " . count($value->showLastThrows()) . " kast:</p>" : null ?>

    <?php foreach ($value->showLastThrows() as $key => $throw) : ?>
        <span class="dicegame">Kast <?= $key + 1 ?>:</span>
        <?php foreach ($throw as $dicevalue) : ?>
            <i class="dice-sprite dice-<?= $dicevalue ?>"></i>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>





