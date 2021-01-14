<?php

namespace Anax\View;

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
    <p><?= $item->textbody ?></p>
</div>


<?php if ($comments) { foreach ($comments as $index => $comment) : ?>
    <div class="commentdiv">
        <div class="commentvote">
            <form class="upvote" action="" method="post">
                <input type="hidden" name="data" value="1;<?= $comment->id ?>;<?= $loginid ?>;qcomment-<?= $comment->id ?>">
                <input type="submit" name="rateqcomment" value="">
            </form>
            <p class="ratingscore"><?= $comment->rating ?></p>
            <form class="downvote" action="" method="post">
                <input type="hidden" name="data" value="-1;<?= $comment->id ?>;<?= $loginid ?>;qcomment-<?= $comment->id ?>">
                <input type="submit" name="rateqcomment" value="">
            </form>
        </div>
        <div class="commenttext">
            <h6 id="qcomment-<?= $comment->id ?>">Kommentar av <a href="<?= url("user/user/{$comment->userid}"); ?>"><?= $comment->username ?></a> (<?= $comment->created ?>)</h6>
            <p><?= $comment->textbody ?></p>
        </div>
    </div>
<?php endforeach;} ?>

<?php foreach ($answers as $index => $answer) : ?>

<div class="questionanswer">

</div>
<h2 id="answer-<?= $answer->id ?>">Svar nr <?= $index + 1 ?></h2>
<div class="vote">
    <form class="upvote" action="" method="post">
        <input type="hidden" name="data" value="1;<?= $answer->id ?>;<?= $loginid ?>;answer-<?= $answer->id ?>">
        <input type="submit" name="rateanswer" value="">
    </form>
    <p class="ratingscore"><?= $answer->rating ?></p>
    <form class="downvote" action="" method="post">
        <input type="hidden" name="data" value="-1;<?= $answer->id ?>;<?= $loginid ?>;answer-<?= $answer->id ?>">
        <input type="submit" name="rateanswer" value="">
    </form>
</div>
<div class="questionanswer">
<p><em>Skrivet av <a href="<?= url("user/user/{$answer->userid}"); ?>"><?= $answer->username ?></a> (<?= $answer->created ?>)</em></p>
<p><?= $answer->textbody ?></p>
</div>
<!-- <p>Poäng: <?= $answer->rating ?></p> -->
    <?php if ($answer->comments) { foreach ($answer->comments as $index => $comment) : ?>
        <div class="commentdiv">
            <div class="commentvote">
                <form class="upvote" action="" method="post">
                    <input type="hidden" name="data" value="1;<?= $comment->id ?>;<?= $loginid ?>;acomment-<?= $comment->id ?>">
                    <input type="submit" name="rateacomment" value="">
                </form>
                <p class="ratingscore"><?= $comment->rating ?></p>
                <form class="downvote" action="" method="post">
                    <input type="hidden" name="data" value="-1;<?= $comment->id ?>;<?= $loginid ?>;acomment-<?= $comment->id ?>">
                    <input type="submit" name="rateacomment" value="">
                </form>
            </div>
            <div class="commenttext">
                <h6 id="acomment-<?= $comment->id ?>">Kommentar av <a href="<?= url("user/user/{$comment->userid}"); ?>"><?= $comment->username ?></a> (<?= $comment->created ?>)</h6>
                <p><?= $comment->textbody ?></p>
            </div>
        </div>

    <?php endforeach;} ?>
<?php endforeach; ?>
