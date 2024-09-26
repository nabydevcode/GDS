<h1> la page Admin </h1>




<table class="table table-hover w-50%">

    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Titre</th>

            <th scope="col">Action</th>
        </tr>
    </thead>
    <?php foreach ($tou as $value): ?>
        <tr>
            <th scope="row">
                <?= $value->id ?>
            </th>

            <td>
                <?= $value->titre ?>
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href=" index.php?p=/article/update/<?= $value->id ?>" type="button"
                        class="btn btn-danger">modifier</a>
                    <a href=" index.php?p=/article/delete/<?= $value->id ?> " type=" button"
                        class="btn btn-warning">Supprimer
                    </a>
                    <a href="index.php?p=/article/editer/<?= $value->id ?> " type="button"
                        class="btn btn-success">Editer</a>
                </div>
            </td>
        </tr>
    <?php endforeach ?>

</table>