<?php

namespace Anax\View;
 
?>

<p>Skapa nytt inlägg</p>
<form class="content-cms" method="post" action="<?= url("content/create") ?>">
    <fieldset>

    <p>
        <label>Title:<br> 
            <input type="text" name="contentTitle" required/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate">Spara</button>
    </p>
    </fieldset>
</form>