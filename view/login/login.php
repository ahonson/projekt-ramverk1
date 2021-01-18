<?php

namespace Anax\View;

?>

<h1>Login</h1>

<p>Du måste vara inloggad för att kunna fråga, svara, kommentera, rösta och redigera din profilsida.</p>

<p <?= $success !== "" ? "class='success'" : null ?>><?= $success ?></p>
<p <?= $failedlogin !== "" ? "class='danger'" : null ?>><?= $failedlogin ?></p>

<form action="" method="post">
    <input type="email" name="email" value="<?= $loginemail ?>" placeholder="Din epostadress">
    <input type="password" name="password" value="" placeholder="Ditt lösenord">
    <input type="submit" name="login" value="LOGIN">
</form>


<!-- <h2>REGISTRERA</h2>
<p>Du kan också skapa ett nytt konto:</p> -->

<!-- <a class="questiontag" href="register">REGISTRERA</a> -->

<!-- <form action="" method="post">
    <input type="submit" name="register" value="REGISTRERA">
</form> -->

<h2>Registrering</h2>

<p <?= $warning !== "" ? "class='danger'" : null ?>><?= $warning ?></p>
<p>Du kan också skapa ett konto. Lösenordet måste innehålla minst en siffra, en liten och en stor bokstav. Minst sex tecken. Varje epostadress måste vara unik.</p>
<form action="" method="post">
    <input type="text" name="username" value="<?= $username ?>" placeholder="Ditt namn"><br>
    <input type="email" name="email" value="<?= $email ?>" placeholder="Din epostadress"><br>
    <input type="password" name="password1" value="" placeholder="Ditt lösenord"><br>
    <input type="password" name="password2" value="" placeholder="Ditt lösenord igen">
    <input type="submit" name="register" value="REGGA DIG">
</form>
