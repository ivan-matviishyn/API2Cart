<span>Errors</span>

<?php
if(!empty($data['errors'])) :
    foreach ($data['errors'] as $key => $value) : ?>
        <span><?= ucfirst($key+1) ?> - <?= $value; ?></span><br>
    <?php endforeach;
endif;
?>

<p align="center">
    <a href="index.php">Main page</a>
</p>
