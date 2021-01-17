<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

?>

<h1>All tags</h1>

<?php if (!$items) : ?>
    <p>Det finns inga taggar att visa.</p>
    <?php
    return;
endif;
?>

<?php foreach ($items as $item) : ?>
    <a class="questiontag" href="<?= url("tag/tag/{$item->id}"); ?>"><?= $item->name ?></a>
<?php endforeach ?>
<!-- <table class="usertable">
    <tr>
        <th>Id</th>
        <th>Namn</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td class="">
            <?= $item->id ?>
        </td>
        <td class=""><a href="<?= url("tag/tag/{$item->id}"); ?>"><?= $item->name ?></a></td>
    </tr>
    <?php endforeach; ?>
</table> -->
