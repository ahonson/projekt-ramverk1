<?php

namespace Anax\View;

?>

<h3>Our top 3 tags</h3>

<?php if (!$top3tags) : ?>
    <p>Det finns inga taggar att visa.</p>
    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Id</th>
        <th>Namn</th>
        <th>Antal frågor</th>
    </tr>
    <?php foreach ($top3tags as $item) : ?>
    <tr>
        <td class="">
            <?= $item->tagid ?>
        </td>
        <td class=""><a href="<?= url("tag/tag/{$item->tagid}"); ?>"><?= $item->name ?></a></td>
        <td><?= $item->ct ?></td>
    </tr>
    <?php endforeach; ?>
</table>
