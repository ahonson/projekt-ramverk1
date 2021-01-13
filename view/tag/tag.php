<?php

namespace Anax\View;

?>

<h1>Antalet frågor med taggen <strong><?= $tag->name ?></strong>: <?= count($questions) ?></h1>


<?php if (count($questions)) : ?>
<table class="usertable">
    <tr>
        <th>Questionid</th>
        <th>Title</th>
        <th>Created</th>
        <th>Score</th>
        <!-- <th>Tags</th> -->
    </tr>
    <?php foreach ($questions as $index => $item) : ?>
    <tr>
        <td class="bookid">
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("question/question/{$item->id}"); ?>"><?= $item->title ?></a></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
        <!-- <td><?= $mytags[$index] ?></td> -->
    </tr>
    <?php endforeach; ?>
</table>
<?php else : ?>
<p>Det finns inga frågor att visa.</p>
<?php endif; ?>
