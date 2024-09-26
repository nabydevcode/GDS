<?php
namespace App\Core;
use App\Models\ScreneauxModel;


namespace App\Core;
use App\Models\ScreneauxModel;



class Main
{
    public function start()
    {
        session_start();

        if (isset($_SESSION['visited'])) {
            $model = new ScreneauxModel();
            $model->vues_increment();
            unset($_SESSION['visited']);
        }


        $uri = $_SERVER['REQUEST_URI'];

        // Gestion des redirections
        if (!empty($uri) && $uri[-1] === '/') {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit;
        }

        // Extraction des paramètres
        $params = [];
        if (isset($_GET['p'])) {
            $params = array_filter(explode('/', ltrim($_GET['p'], '/')), fn($value) => $value !== '');
        }

        if (isset($_GET['annee'])) {
            $params[] = $_GET['annee'];
        }
        if (isset($_GET['mois'])) {
            $params[] = $_GET['mois'];
        }

        if (isset($params[0]) && $params[0] != '') {
            $controllerName = array_shift($params);
            $controllerClass = "\\App\\Controllers\\" . ucfirst($controllerName) . 'Controller';

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass;

                $action = !empty($params) ? array_shift($params) : 'index';

                if (method_exists($controller, $action)) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    http_response_code(404);
                    echo "La méthode '{$action}' n'existe pas dans la classe '{$controllerClass}'.";
                }
            } else {
                http_response_code(404);
                echo "La classe '{$controllerClass}' n'existe pas.";
            }
        } else {
            $art = new \App\Controllers\MainController();
            $art->index();
        }
    }
}
