<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

?>

<h1>All questions</h1>

<?php if (!$items) : ?>
    <p>Det finns inga frågor att visa.</p>
    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Questionid</th>
        <th>Userid</th>
        <th>Title</th>
        <th>Textbody</th>
        <th>Created</th>
        <th>Score</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td class="bookid">
            <!-- <a href="<?= url("book/update/{$item->id}"); ?>"><?= $item->id ?></a> -->
            <?= $item->id ?>
        </td>
        <td class=""><?= $item->userid ?></td>
        <td class=""><?= $item->title ?></td>
        <td class=""><?= $item->textbody ?></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
    </tr>
    <?php endforeach; ?>
</table>
