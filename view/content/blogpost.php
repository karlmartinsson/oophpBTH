<?php

namespace Anax\View;

$res = $res[0];
$filters = explode(",", $res->filter);

$textfilter = new \Karl\TextFilter\MyTextFilter()

?>
<h1><?= $res->title ?></h1>


<?= $textfilter->parse($res->data, $filters) ?>

</pre>


