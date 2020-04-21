<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>Tärningsspelet</h1>

<br>
<br>
<form method="post" action="dice/init">

<p>Antal tärningar (min 1, max 6)</p><br>
<p><input type="number" name="dices" min="1" max="6"></input></p>

<p>Antal motståndare (min 1, max 10)</p><br>

<p><input type="number" name="opponents" min="1" max="10"></input></p>

<p><input class="button" type="submit" name="submit" value="Spela"></input></p>

</form>
