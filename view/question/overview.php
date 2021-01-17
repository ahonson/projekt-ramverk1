<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

?>

<h1>All questions</h1>
<p><a class="questiontag" href="question/newquestion">Ask new question</a></p>

<?php if (!$items) : ?>
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
        <th>Answers</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($items as $index => $item) : ?>
    <tr>
        <td class="bookid">
            <!-- <a href="<?= url("book/update/{$item->id}"); ?>"><?= $item->id ?></a> -->
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("question/question/{$item->id}"); ?>"><?= $item->title ?></a></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
        <td><?= $item->answercount ?></td>
        <td><?= $mytags[$index] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
