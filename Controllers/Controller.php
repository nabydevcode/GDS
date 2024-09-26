<?php

namespace App\Controllers;

class Controller
{

    public function render(string $fichier, array $tab = [])
    {
        extract($tab);

        ob_start();
        require('../Views/' . $fichier . '.php');
        $contenue = ob_get_clean();
        require_once('../Views/default.php');
    }
}