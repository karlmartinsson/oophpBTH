<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>


<table>
    <tr class="first">
        <th>Rad </th>
        <th>Id </th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År </th>
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


