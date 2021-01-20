<?php

namespace Anax\View;

?>

<h2>De tre mest aktiva användarna</h2>

<?php if (!$top3users) : ?>
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
        <th>Totalt</th>
        <th>Frågor</th>
        <th>Svar</th>
        <th>Kommentarer</th>
        <th>Score</th>
    </tr>
    <?php foreach ($top3users as $item) : ?>
    <tr>
        <td class="bookid">
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("user/user/{$item->id}"); ?>"><?= $item->name ?></a></td>
        <td class=""><?= $item->email ?></td>
        <td class=""><img src="<?= $item->gravatar ?>" alt="Gravatar for <?= $item->name ?>"></td>
        <td><?= $item->created ?></td>
        <td><?= $item->total ?></td>
        <td><?= $item->questions ?></td>
        <td><?= $item->answers ?></td>
        <td><?= $item->comments ?></td>
        <td><?= $item->rating ?></td>
    </tr>
    <?php endforeach; ?>
</table>
