<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

?>

<h1>All users</h1>

<?php if (!$items) : ?>
    <p>Det finns inga användare att visa.</p>
    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Id</th>
        <th>Namn</th>
        <th>Epost</th>
        <th>Gravatar</th>
        <th>Created</th>
        <th>Score</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td class="bookid">
            <!-- <a href="<?= url("book/update/{$item->id}"); ?>"><?= $item->id ?></a> -->
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("user/user/{$item->id}"); ?>"><?= $item->name ?></a></td>
        <td class=""><?= $item->email ?></td>
        <td class=""><img src="<?= $item->gravatar ?>" alt="Gravatar for <?= $item->name ?>"></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
    </tr>
    <?php endforeach; ?>
</table>
