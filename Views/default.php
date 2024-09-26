<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GDS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/index.php?p=/main/index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/article/index">Les Artilces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/article/register">Ajouter Article</a>
                        </li>
                        <?php if (($_SESSION['user'][2] === 'Admin')): ?>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="/index.php?p=/screneaux/index&annee=<?= date('Y') ?>&mois=<?= date('m') ?>">Flux-monsite</a>
                            </li>
                        <?php endif ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/contact/contacter">Nous-Contacter</a>
                        </li>

                    <?php endif ?>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (($_SESSION['user'][2] === 'Admin')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/index.php?p=/main/general">Administateur</a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/users/deconnection">Deconnection</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/users/login">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?p=/users/register">Inscrire</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>


    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                <?= $_SESSION['error'];
                unset($_SESSION['error']) ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_SESSION['danger'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                <?= $_SESSION['danger'];
                unset($_SESSION['danger']) ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php elseif (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>
                <?= $_SESSION['message'];
                unset($_SESSION['message']) ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_SESSION['warning'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>
                <?= $_SESSION['warning'];
                unset($_SESSION['warning']) ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>
                <?= $_SESSION['success'];
                unset($_SESSION['success']) ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php endif; ?>

    <div class="container">
        <?= $contenue ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>