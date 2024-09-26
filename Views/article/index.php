<h2> La prise de note</h2>
<div class="container">
    <div class="row">
        <?php foreach ($articles as $key => $value): ?>
            <div class="col-4 g-2">
                <div class="card " style="width:100%;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $value->titre ?>
                        </h5>
                        <p class="card-text">
                            <?= $value->message ?>
                        </p>
                        <a href="/index.php?p=/article/lire/<?= $value->id ?>" class="btn btn-success">
                            details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>