<?php

namespace Anax\View;
 
?>

<p>Ta bort filmen</p>
<form method="post" action="<?= url("movie/delete") ?>">
    <fieldset>
    
    <input type="hidden" name="movieId" value="<?= isset($res) ? $res->id : "new" ?>"/>

    <p>
        <label>Titel:<br> 
        <input type="text" name="movieTitle" value="<?= isset($res) ? $res->title : null ?>" readonly/>
        </label>
    </p>

    <p>
        <label>Produktionsår:<br> 
        <input type="number" name="movieYear" value="<?= isset($res) ? $res->year : null ?>" readonly/>
    </p>

    <p>
        <label>Sökväg till bild:<br> 
        <input type="text" name="movieImage" value="<?= isset($res) ? $res->image : null ?>" readonly/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Ta bort">
    </p>
    <p>

    </p>
    </fieldset>
</form>
