<?php

namespace Anax\View;

use Michelf\MarkdownExtra;

$markdown = new MarkdownExtra();

?>
<h1 id="question-<?= $item->id ?>">Fråga nr <?= $item->id ?>: <?= $item->title ?></h1>
<div class="vote">
    <form class="upvote" action="" method="post">
        <input type="hidden" name="data" value="1;<?= $item->id ?>;<?= $loginid ?>;question-<?= $item->id ?>">
        <input type="submit" name="ratequestion" value="">
    </form>
    <p class="ratingscore"><?= $item->rating ?></p>
    <form class="downvote" action="" method="post">
        <input type="hidden" name="data" value="-1;<?= $item->id ?>;<?= $loginid ?>;question-<?= $item->id ?>">
        <input type="submit" name="ratequestion" value="">
    </form>
</div>

<div class="questionanswer">
    <p><em>Publicerad av <a href="<?= url("user/user/{$user->id}"); ?>"><?= $user->name ?></a> (<?= $item->created ?>)</em></p>
    <p><?= $markdown->defaultTransform($item->textbody) ?></p>
</div>
<p><strong>Taggar</strong>:
    <?php foreach ($item->tags as $key => $tag): ?>
        <a class="questiontag" href="../../tag/tag/<?= $key ?>"><?= $tag ?></a>
    <?php endforeach; ?>
</p>

<div class="answerdiv">
    <form class="" action="" method="post">
        <label for="answertext">Svara på frågan</label>
        <textarea name="answertext" rows="4" cols="40"></textarea>
        <input type="hidden" name="data" value=";<?= $item->id ?>;<?= $loginid ?>;answer-<?= count($answers) + 1 ?>">
        <input type="submit" name="sendanswer" value="Skicka">
    </form>
</div>

<?php if ($comments) { foreach ($comments as $index => $comment) : ?>
    <div class="commentdiv">
        <div class="commentvote">
            <form class="upvote" action="" method="post">
                <input type="hidden" name="data" value="1;<?= $comment->id ?>;<?= $loginid ?>;qcomment-<?= $index + 1 ?>">
                <input type="submit" name="rateqcomment" value="">
            </form>
            <p class="ratingscore"><?= $comment->rating ?></p>
            <form class="downvote" action="" method="post">
                <input type="hidden" name="data" value="-1;<?= $comment->id ?>;<?= $loginid ?>;qcomment-<?= $index + 1 ?>">
                <input type="submit" name="rateqcomment" value="">
            </form>
        </div>
        <div class="commenttext">
            <h6 id="qcomment-<?= $index + 1 ?>">Kommentar av <a href="<?= url("user/user/{$comment->userid}"); ?>"><?= $comment->username ?></a> (<?= $comment->created ?>)</h6>
            <p><?= $markdown->defaultTransform($comment->textbody) ?></p>
        </div>
    </div>
<?php endforeach;} ?>
<div class="qcommentdiv">
    <form class="" action="" method="post">
        <label for="qcommenttext">Skriv en kommentar</label>
        <textarea name="qcommenttext" rows="4" cols="40"></textarea>
        <input type="hidden" name="data" value=";<?= $item->id ?>;<?= $loginid ?>;qcomment-<?= count($comments) + 1 ?>">
        <input type="submit" name="sendqcomment" value="Skicka">
    </form>
</div>

<?php foreach ($answers as $index => $answer) : ?>

<div class="questionanswer">

</div>
<h2 id="answer-<?= $index + 1 ?>">Svar nr <?= $index + 1 ?></h2>
<div class="vote">
    <form class="upvote" action="" method="post">
        <input type="hidden" name="data" value="1;<?= $answer->id ?>;<?= $loginid ?>;answer-<?= $index + 1 ?>">
        <input type="submit" name="rateanswer" value="">
    </form>
    <p class="ratingscore"><?= $answer->rating ?></p>
    <form class="downvote" action="" method="post">
        <input type="hidden" name="data" value="-1;<?= $answer->id ?>;<?= $loginid ?>;answer-<?= $index + 1 ?>">
        <input type="submit" name="rateanswer" value="">
    </form>
</div>
<div class="questionanswer">
<p><em>Skrivet av <a href="<?= url("user/user/{$answer->userid}"); ?>"><?= $answer->username ?></a> (<?= $answer->created ?>)</em></p>
<p><?= $markdown->defaultTransform($answer->textbody) ?></p>
</div>
<!-- <p>Poäng: <?= $answer->rating ?></p> -->
    <?php if ($answer->comments) { foreach ($answer->comments as $index => $comment) : ?>
        <div class="commentdiv">
            <div class="commentvote">
                <form class="upvote" action="" method="post">
                    <input type="hidden" name="data" value="1;<?= $comment->id ?>;<?= $loginid ?>;acomment-<?= $index + 1 ?>">
                    <input type="submit" name="rateacomment" value="">
                </form>
                <p class="ratingscore"><?= $comment->rating ?></p>
                <form class="downvote" action="" method="post">
                    <input type="hidden" name="data" value="-1;<?= $comment->id ?>;<?= $loginid ?>;acomment-<?= $index + 1 ?>">
                    <input type="submit" name="rateacomment" value="">
                </form>
            </div>
            <div class="commenttext">
                <h6 id="acomment-<?= $index + 1 ?>">Kommentar av <a href="<?= url("user/user/{$comment->userid}"); ?>"><?= $comment->username ?></a> (<?= $comment->created ?>)</h6>
                <p><?= $markdown->defaultTransform($comment->textbody) ?></p>
            </div>
        </div>

    <?php endforeach;} ?>
    <div class="qcommentdiv">
        <form class="" action="" method="post">
            <label for="acommenttext">Skriv en kommentar</label>
            <textarea name="acommenttext" rows="4" cols="40"></textarea>
            <input type="hidden" name="data" value=";<?= $answer->id ?>;<?= $loginid ?>;acomment-<?= count($answer->comments) + 1 ?>">
            <input type="submit" name="sendacomment" value="Skicka">
        </form>
    </div>

<?php endforeach; ?>
