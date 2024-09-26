<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\ScreneauxModel;


class ScreneauxController extends Controller
{

    public function index($anneeSelectionner, $moisSelectionner = null)
    {
        $year = date('Y');
        $anneeSelectionner = $anneeSelectionner ? $anneeSelectionner : $year;
        $moisSelectionner = $moisSelectionner ? $moisSelectionner : date('m');
        $model = new ScreneauxModel();
        $nombre = $model->vues_par_mois($anneeSelectionner, $moisSelectionner);
        $details = $model->details_vues_par_mois($anneeSelectionner, $moisSelectionner);
        return $this->render('flux/index', compact('nombre', 'details', 'anneeSelectionner', 'moisSelectionner', 'year'));
    }
}