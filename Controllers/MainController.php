<?php

namespace App\Controllers;
use App\Core\Form;
use App\Models\ArticleModel;
use App\Models\ContactModel;
use App\Models\ScreneauxModel;



class MainController extends Controller
{


    public function index()
    {
        ob_start();
        return $this->render('main/home');
        $contenue = ob_get_clean();
    }

    public function general()
    {

        $admin = new ArticleModel();
        $tou = $admin->findAll();
        return $this->render('admin/index', ['tou' => $tou]);

    }

}
