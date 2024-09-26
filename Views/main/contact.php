<?php

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1>Page de contact</h1>
            <?= $form1 ?>
        </div>
        <div class="col-6">
            <!-- Message d'ouverture ou de fermeture du magasin -->
            <?php if ($boll): ?>
                <div class="alert alert-success">
                    Le magasin est ouvert
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    Le magasin est fermé
                </div>
            <?php endif; ?>

            <!-- Affichage du formulaire -->
            <?= $form ?>

            <!-- Affichage des horaires par jour -->

            <?php foreach (SEMAINE as $key => $value): ?>

                <strong>
                    <?= $value ?> :

                </strong>
                <?= $key ?>

                <?= $html[$key] ?>

                <br>
            <?php endforeach; ?>
        </div>
    </div>
</div>