<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>Gissa numret</h1>
<?php 

$game = $_SESSION["game"];

if (isset($_SESSION["result"]) && $_SESSION["result"] == "Du gissade rätt") {
    echo "<h2>Grattis, du vann!!</h2>";
    echo "<p>Klicka på \"Börja om\" för att starta ett nytt spel.</p>";
} elseif ($game->tries() > 0) {
    echo "<p>Gissa ett nummer mellan 1 och 100. Du har " . $game->tries() . " försök kvar.</p>";
} else {
    echo "<p>Du har slut på gissningar. Tryck på \"Börja om\" för att försöka igen.</p>";
}
?>
    <form class="label-left" method="post" action="make-guess">
        <input id="number" type="number" name="number" value="<?= htmlentities($_POST["title"] ?? null) ?>">
        <button class="button<?= $game->tries() < 1 || $_SESSION["result"] == "Du gissade rätt" ? " hidden" : "" ?>" type="submit" name="guess" value="Gissa">Gissa</button>
    </form>
    <form action="init">
        <button class="button" type="submit" value="Börja om" >Börja om</button>
    </form>
    <form method="get" >
    <input id="fuska" type="hidden" name="fuska" value="true">
    <button class="button" type="submit" value="Fuska">Fuska</button>
    </form>



<?php
if (isset($_SESSION["exception"])) {
    echo "<p>" . $_SESSION["exception"] . "</p>";
} elseif (isset($_SESSION["guess-data"]) && isset($_SESSION["result"])) {
    echo "<p>Du gissade " . $_SESSION["guess-data"]["number"] . ". " .$_SESSION["result"] . "</p>";
}
?>

<?= isset($_GET["fuska"]) ? "<p>FUSKLÄGE PÅ – Det hemliga numret är: " . $game->number() . "</p>": null ?>

<?php 
$_SESSION["exception"] = null;
?>