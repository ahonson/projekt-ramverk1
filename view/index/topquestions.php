<?php

namespace Anax\View;

?>

<h2>De tre senaste frågorna</h2>

<?php if (!$top3questions) : ?>
    <p>Det finns inga frågor att visa.</p>
    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Questionid</th>
        <!-- <th>Userid</th> -->
        <th>Title</th>
        <th>Created</th>
        <th>Score</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($top3questions as $index => $item) : ?>
    <tr>
        <td class="bookid">
            <!-- <a href="<?= url("book/update/{$item->id}"); ?>"><?= $item->id ?></a> -->
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("question/question/{$item->id}"); ?>"><?= $item->title ?></a></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
        <td><?= $mytags[$index] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
