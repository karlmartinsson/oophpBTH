<?php

namespace Anax\View;

if (!$resultset) {
    return;
}
$textfilter = new \Karl\TextFilter\MyTextFilter();

?>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="<?= url('content/post/' . $textfilter->esc($row->slug)) ?>"><?= $textfilter->esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= $textfilter->esc($row->published_iso8601) ?>" pubdate><?= $textfilter->esc($row->published) ?></time></i></p>
    </header>
    <?= trim($textfilter->esc($row->data_short)) . "... <a href='" .  url('content/post/' . $textfilter->esc($row->slug)) . "'>Läs mer</a>" ?>
</section>
<?php endforeach; ?>