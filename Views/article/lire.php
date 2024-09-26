<h1>
    la details
</h1>
<?php ?>
<h1>
    <?= $articles->titre ?>
</h1>

<p>

<h3> Descriptions:</h3>
<?= $articles->message ?>
</p>
Actif:
<?= $articles->actif ?>
<p>User_id:
    <?= $articles->user_id ?>
</p>

<a href="index.php?p=/article/update/<?= $articles->id ?>" class="btn btn-primary"> Modifier</a>