<?php

namespace Anax\View;

if (count($items) === 1) {
    $qu = "fråga";
    $comment = "kommentar";
} else {
    $qu = "frågor";
    $comment = "kommentarer";
}

if (count($allcomments) === 1) {
    $comment = "kommentar";
}  else {
    $comment = "kommentarer";
}
?>

<h1><img src="<?= $user->gravatar?>" alt="gravatar"> <?= $user->name?> har skrivit</h1>

<h5><?= count($items) . " " . $qu ?></h5>
<?php if ($items) : ?>
<table class="usertable">
    <tr>
        <th>Questionid</th>
        <th>Title</th>
        <th>Created</th>
        <th>Score</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($items as $index => $item) : ?>
    <tr>
        <td class=""><?= $item->id ?></td>
        <td class=""><a href="<?= url("question/question/{$item->id}"); ?>"><?= $item->title ?></a></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
        <td><?= $mytags[$index] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>


<h5><?= count($allanswers) . " svar" ?></h5>
<?php if ($allanswers) : ?>
<table class="usertable">
    <tr>
        <th>See Question</th>
        <th>Text</th>
        <th>Created</th>
        <th>Score</th>
    </tr>
    <?php foreach ($allanswers as $index => $item) : ?>
    <tr>
        <td class=""><a href="<?= url("question/question/{$item->questionid}"); ?>"> nr <?= $item->questionid ?></a></td>
        <td><?= $item->info ?></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>



<h5><?= count($allcomments) . " " . $comment ?></h5>
<?php if ($allcomments) : ?>
<table class="usertable">
    <tr>
        <th>See Question</th>
        <th>Text</th>
        <th>Created</th>
        <th>Score</th>
    </tr>
    <?php foreach ($allcomments as $index => $item) : ?>
    <tr>
        <td class=""><a href="<?= url("question/question/{$item->questionid}"); ?>"> nr <?= $item->questionid ?></a></td>
        <td><?= $item->info ?></td>
        <td><?= $item->created ?></td>
        <td><?= $item->rating ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
