<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

?>

<h1>All tags</h1>

<?php if (!$items) : ?>
    <p>Det finns inga taggar att visa.</p>
    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Id</th>
        <th>Namn</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td class="bookid">
            <!-- <a href="<?= url("book/update/{$item->id}"); ?>"><?= $item->id ?></a> -->
            <?= $item->id ?>
        </td>
        <td class=""><?= $item->name ?></td>
    </tr>
    <?php endforeach; ?>
</table>
