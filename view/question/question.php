<?php

namespace Anax\View;

?>

<h1>Fråga nr <?= $item->id ?>: <?= $item->title ?></h1>
<p><em>Publicerad av <?= $user->name ?> (<?= $item->created ?>)</em></p>
<p><?= $item->textbody ?></p>
<p>Poäng: <?= $item->rating ?></p>

<?php if ($comments) { foreach ($comments as $index => $comment) : ?>
    <h6>Kommentar av <?= $comment->username ?> (<?= $comment->created ?>)</h6>
    <p><?= $comment->textbody ?></p>
    <p>Poäng: <?= $comment->rating ?></p>
<?php endforeach;} ?>

<?php foreach ($answers as $index => $answer) : ?>
<h2>Svar nr <?= $index + 1 ?></h2>
<p><em>Skrivet av <?= $answer->username ?> (<?= $answer->created ?>)</em></p>
<p><?= $answer->textbody ?></p>
<p>Poäng: <?= $answer->rating ?></p>
<?php endforeach; ?>
