<?php

define(
    'SEMAINE',
    [
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
        'Dimanche'
    ]
);

define(
    'MOIS',
    [
        '01' => 'janvier',
        '02' => 'fevrier',
        '03' => 'mars',
        '04' => 'avril',
        '05' => 'mai',
        '06' => 'juin',
        '07' => 'juillet',
        '08' => 'août',
        '09' => 'setpembre',
        '10' => 'octobre',
        '11' => 'novembre',
        '12' => 'decembre',
    ]

);

?>
<div class="container">
    <h1> Dashboard de mon site</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="width: 20rem;">
                <div class="list-group text-center">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <a class="list-group-item <?= $year - $i == $anneeSelectionner ? 'active' : ''; ?>"
                            href="/index.php?p=screneaux/index/&annee=<?= $year - $i ?>">
                            <?= $year - $i ?>
                        </a>
                        <?php if ($year - $i == $anneeSelectionner): ?>
                            <div class="list-group">
                                <?php foreach (MOIS as $key => $value): ?>
                                    <a class="list-group-item <?= $moisSelectionner == $key ? 'active' : ''; ?>"
                                        href="/index.php?p=/screneaux/index/&annee=<?= $anneeSelectionner ?>&mois=<?= $key ?>">
                                        <?= $value ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endfor ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <strong style="font-size: 3rem;">
                        <?= $nombre ?>
                    </strong> <br>
                    Visite
                    <?= $nombre > 1 ? 's' : '' ?> total
                </div>
            </div>
            <?php if (isset($details) && !empty($details)): ?>
                <h2>Détails des screneaux</h2>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Année</th>
                            <th>Mois</th>
                            <th>Jour</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $line): ?>
                            <tr>
                                <td>
                                    <?= $line['annee'] ?>
                                </td>
                                <td>
                                    <?= $line['mois'] ?>
                                </td>
                                <td>
                                    <?= $line['jour'] ?>
                                </td>
                                <td>
                                    <?= $line['total'] ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>