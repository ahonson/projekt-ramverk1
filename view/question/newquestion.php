<?php

namespace Anax\View;

?>
<h1>Ny fråga</h1>

<form method="post">
    <fieldset>
    <legend>Create</legend>
    <p>
        <label>Title:<br>
        <input type="text" name="title" value="<?= $title ?>"/>
        </label>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="textbody"><?= $textbody ?></textarea>
    </p>

     <p>
         <label>Choose tags</label><br>
         <?php foreach ($tags as $key => $tag) : ?>
             <input type="checkbox" id="<?= $tag->name?>" name="tagname[]" value="<?= $tag->id ?>">
             <label for="<?= $tag->name?>"> <?= $tag->name?></label><br>
         <?php endforeach; ?>
    </p>
    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
    </p>
    </fieldset>
</form>
