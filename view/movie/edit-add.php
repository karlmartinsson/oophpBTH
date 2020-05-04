<?php

namespace Anax\View;
 
?>
 <p>Redigera uppgifterna om filmen:</p>
<form method="post" action="<?= url("movie/save") ?>">
    <fieldset>
   
    <input type="hidden" name="movieId" value="<?= isset($res) ? $res->id : "new" ?>"/>

    <p>
        <label>Titel:<br> 
        <input type="text" name="movieTitle" value="<?= isset($res) ? $res->title : null ?>"/>
        </label>
    </p>

    <p>
        <label>Produktionsår:<br> 
        <input type="number" name="movieYear" value="<?= isset($res) ? $res->year : null ?>"/>
    </p>

    <p>
        <label>Sökväg till bild:<br> 
        <input type="text" name="movieImage" value="<?= isset($res) ? $res->image : null ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Spara ändringar">
    </p>
    <p>

    </p>
    </fieldset>
</form>
