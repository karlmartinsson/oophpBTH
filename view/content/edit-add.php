<?php

namespace Anax\View;

$res = $res[0];

/**
 * Create a slug of a string, to be used as url.
 *
 * @param string $str the string to format as slug.
 * 
 * @return str the formatted slug.
 */
function slugify($str)
{
    $str = mb_strtolower(trim($str));
    $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = trim(preg_replace('/-+/', '-', $str), '-');
    return $str;
}
 
?>

 <p>Redigera inlägget:</p>
<form class="content-cms" method="post" action="<?= url("content/edit") ?>">
    <fieldset>
   
    <input type="hidden" name="contentId" value="<?= isset($res) ? $res->id : "new" ?>"/>

    <p>
    <label>Title:<br> 
    <input type="text" name="contentTitle" value="<?= htmlentities($res->title) ?>"/>
</p>
<p>
    <label>Path:<br> 
    <input type="text" name="contentPath" value="<?= htmlentities($res->path) ?>"/>
</p>

    <p>
    <label>Slug:<br> 
    <input type="text" name="contentSlug" value="<?= $res->slug ? htmlentities($res->slug) : slugify(htmlentities($res->title)) ?>"/>
</p>
<p>
    <label>Type:<br> 
    <input type="text" name="contentType" value="<?= htmlentities($res->type) ?>"/>
</p>
<p>
    <label>Filter:<br> 
    <input type="text" name="contentFilter" value="<?= htmlentities($res->filter) ?>"/>
</p>
<p>
    <label>Text:<br> 
    <textarea name="contentData"><?= htmlentities($res->data) ?></textarea>
 </p>

 <p>
     <label>Publish:<br> 
     <input type="datetime" name="contentPublish" value="<?= htmlentities($res->published) ?>"/>
 </p>

    <p>
        <input type="submit" name="doSave" value="Spara ändringar">
    </p>
    <p>

    </p>
    </fieldset>
</form>
