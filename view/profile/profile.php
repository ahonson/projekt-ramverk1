<?php

namespace Anax\View;

?>

<h1><img src="<?= $user->gravatar ?>" alt="gravatar for <?= $user->name ?>"> <strong><?= $user->name ?>s profil</strong> <img src="<?= $user->gravatar ?>" alt="gravatar for <?= $user->name ?>"></h1>

<p>Din epostadress är: <strong><?= $user->email ?></strong></p>
<p>Ditt konto skapades <strong><?= $user->created ?></strong>.</p>
<?php if ($user->updated) : ?>
    <p>Profiluppgifterna uppdaterades senast: <?= $user->updated ?>.</p>
<?php endif; ?>
<p>Ditt reputationscore är <strong><?= $user->rating ?></strong>.</p>
<p>Du har skrivit <strong><?= $user->questions ?> frågor</strong>, <strong><?= $user->answers ?> svar</strong> och <strong><?= $user->comments ?> kommentarer</strong>.</p>
<p>Du har skrivit <strong><?= $user->accepted ?> accepterade svar</strong>.</p>
<p>Du har röstat <strong><?= $user->up + $user->down ?> gånger</strong> (<?= $user->up ?> uppåtröster och <?= $user->down ?> nedåtröster).</p>

<h2>Nytt lösenord</h2>
<p>Här kan du ändra ditt namn och ditt lösenord. OBS! Ett giltigt lösenord består av minst 6 tecken. Det innehåller minst en siffra, en liten och en stor bokstav.</p>

<form class="" action="" method="post">
    <fieldset>
        <legend>Ändra din profil</legend>
        <label for="newname">Ditt nya namn.</label><br>
        <input type="text" name="newname" value="<?= $user->name ?>"><br><br>
        <label for="currentpass">Ditt nuvarande lösenord.</label><br>
        <input type="password" name="currentpass" value=""><br><br>
        <label for="newpass1">Ditt nya lösenord.</label><br>
        <input type="password" name="newpass1" value=""><br><br>
        <label for="newpass2">Ditt nya lösenord en gång till.</label><br>
        <input type="password" name="newpass2" value="">
        <input type="submit" name="submit" value="ÄNDRA">
    </fieldset>
</form>
