<?php

namespace Anax\View;

function mergeQueryString($options, $prepend = "?")
{
    // Parse querystring into array
    $query = [];
    parse_str($_SERVER["QUERY_STRING"], $query);

    // Merge query string with new options
    $query = array_merge($query, $options);

    // Build and return the modified querystring as url
    return $prepend . http_build_query($query);
}

function orderby($column)
{
    return '<span class="orderby">' .
        '<a href="' . mergeQueryString(["orderBy" => $column]) . '&order=asc">&darr;</a>' .
        '<a href="' . mergeQueryString(["orderBy" => $column]) . '&order=desc">&uarr;</a></span>';
}



if (!$res) {
    return;
}
?>

<p>Filmer per sida: 
    <a href="<?= mergeQueryString(["hits" => 2]) ?>">2</a> |
    <a href="<?= mergeQueryString(["hits" => 4]) ?>">4</a> |
    <a href="<?= mergeQueryString(["hits" => 8]) ?>">8</a>
</p>

<table>
    <tr class="first">
        <th>Rad </th>
        <th>Id <?= orderby("id") ?></th>
        <th>Bild</th>
        <th>Titel <?= orderby("title") ?></th>
        <th>År <?= orderby("year") ?></th>
        <th class="table-right-align">Redigera / ta bort</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= url("image/" . $row->image . "?w=100&h=60&crop-to-fit") ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td class="table-right-align"><a href="<?= url("movie/edit/" . $row->id) ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= url("movie/delete/" . $row->id) ?>"><i class="fas fa-trash"></i></a>
    </tr>
<?php endforeach; ?>
</table>
<p>
    Sidor:
    <?php for ($i = 1; $i <= $max; $i++) : ?>
        <a href="<?= mergeQueryString(["page" => $i]) ?>"><?= $i ?></a> 
    <?php endfor; ?>
</p>

