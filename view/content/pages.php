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

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php foreach ($res as $row) : ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><a href="<?= url('content/page/' . $row->path) ?>"><?= $row->title ?></a></td>
        <td><?= $row->type ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
