<h1> Register Articles</h1>
<?php foreach ($message as $key => $value): ?>
    <?php if ($key == 'message'): ?>
        <div class="alert alert-success">
            <?= $value ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <?= $value ?>
        </div>
    <?php endif ?>
<?php endforeach ?>

<?= $form ?>