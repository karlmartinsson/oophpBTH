<?php

namespace Anax\View;

?>
<h2>Sök efter filmtitel eller produktionsdatum</h2>
<form method="get">

    <p>Titel:</p>
    <p><input type="search" name="searchTitle" value="<?= isset($title) ? htmlentities($title) : null ?>"/></p>

    <p>Producerad mellan:</p>
    <p>
    <input type="number" name="year1" value="<?= isset($year1) ? htmlentities($year1) : null ?>" min="1900" max="2100"/>
    - 
    <input type="number" name="year2" value="<?= isset($year2) ? htmlentities($year2) : null ?>" min="1900" max="2100"/>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Sök">
    </p>
</form>