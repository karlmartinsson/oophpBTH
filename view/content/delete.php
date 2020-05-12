<?php

namespace Anax\View;

$res = $res[0];
?>

<p>Delete</p>
<form class="content-cms" method="post" action="<?= url("content/delete") ?>">
    <fieldset>
    

    <input type="hidden" name="contentId" value="<?= htmlentities($res->id) ?>"/>

    <p>
        <label>Title:<br> 
            <input type="text" name="contentTitle" value="<?= htmlentities($res->title) ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>