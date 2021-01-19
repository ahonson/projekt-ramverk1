<?php

namespace Anax\View;

?>

<h1>Hej <?= $user->name ?>!!!</h1>

<p>Det här är din profilsida.</p>
<p>Det här är din epostadress: <strong><?= $user->email ?></strong></p>
<p>Ditt konto skapades <?= $user->created ?>.</p>

<p>Ditt ID är <?= $loginid ?></p>
