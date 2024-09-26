<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Core\Form;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function index()
    {
        $art = new ArticleModel();
        $articles = $art->findAll();
        return $this->render('article/index', ['articles' => $articles]);
    }
    public function lire($id)
    {
        $article = new ArticleModel();
        $articles = $article->find($id);
        return $this->render('article/lire', ['articles' => $articles]);
    }
    public function create()
    {
        $article = (new ArticleModel())
            ->setTitre('Informaticien')
            ->setMessage('Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis ipsa incidunt quos explicabo, sapiente similique quis cum est! Temporibus accusantium sequi, beatae corrupti commodi reiciendis neque deleniti? Recusandae, ullam tenetur!
                   Molestias maxime odio quod, blanditiis ipsum ipsa veritatis. Repellat quis, voluptates velit sapiente sunt eaque eos rerum corrupti facere nihil nobis molestias, voluptatum adipisci doloribus beatae fugit facilis necessitatibus nisi.
                   Dicta blanditiis, porro ducimus odio earum quasi deleniti commodi nulla expedita numquam dignissimos ipsam quo excepturi reprehenderit iste, ipsa debitis repellendus, quod culpa. Temporibus, consequatur! Sapiente ab debitis voluptate perferendis!
                   Assumenda, et voluptates. Aspernatur reprehenderit quae quam sapiente. Porro velit magnam sunt ad temporibus non maxime at culpa alias incidunt illo earum, ab et blanditiis minus? Magnam fuga laudantium numquam.
                   Hic nihil id alias repellat, cum ab placeat voluptas temporibus consectetur architecto accusamus earum quisquam aspernatur ipsam! Quas, quam asperiores ratione quasi maxime sequi veniam ad provident repellendus aut nobis!')
            ->setActif(1);

        $article->create();
        $this->render('article/create');
    }

    public function update()
    {

        if (isset($_GET['p'])) {

            $var = explode('/', $_GET['p']);

            var_dump($var);

            $vart = $var[3];
            if (filter_var($vart, FILTER_VALIDATE_INT)) {
                $article = new ArticleModel();
                $annonce = $article->find($vart);
                if ($_SESSION['user'][0] === $annonce->user_id || $_SESSION['user'][2] === 'Admin') {
                    if ($annonce) {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Récupère les données du formulaire et les met à jour
                            $article->setId($annonce->id)
                                ->setTitre($_POST['titre'])
                                ->setMessage($_POST['descriptions']);
                            $article->update();
                            if ($_SESSION['user'][2] === 'Admin') {
                                header('Location: /index.php?p=/main/general');
                                exit;
                            }
                            header('Location: /index.php?p=/article/index ');
                            exit;
                        }
                        // Formulaire de mise à jour
                        $form = new Form();
                        $form->debuForm('post', '#')
                            ->ajoutLabelFor('titre', 'Titre:')
                            ->ajoutInput('text', 'titre', ['class' => 'form-control', 'required' => true, 'placeholder' => 'info', 'value' => $annonce->titre])
                            ->textArea('descriptions', $annonce->message, ['class' => 'form-control my-1', 'placeholder' => 'Descriptions de l\'article'])
                            ->ajoutButon('Mettre à jour', ['class' => 'btn btn-primary'])
                            ->formFin();
                        return $this->render('/article/update', ['form' => $form->create()]);
                    } else {
                        $_SESSION['error'] = "L'article n'existe pas.";
                    }
                } else {
                    $_SESSION['danger'] = " Vous avez pas droit sur cet Article";
                    header('Location: /index.php?p=/article/index');
                    exit;
                }
            }
        } else {
            header('Location: /index.php?p=/main/index');
            exit;
        }

    }

    public function register()
    {
        $message = [];
        if (isset($_POST['titre'], $_POST['descriptions']) && !empty($_POST['titre']) && !empty($_POST['descriptions'])) {
            $titre = strip_tags(trim($_POST['titre']));
            $descriptions = nl2br(strip_tags(trim($_POST['descriptions'])));

            $article = new ArticleModel();
            $article->setTitre($titre);
            $article->setMessage($descriptions);
            $article->setActif(0);
            $article->setUser_id($_SESSION['user'][0]);
            $article->create();
            $message['message'] = " La article a ete ajouter avec success ";
            header('Location: /index.php?p=/article/index');
        } else {
            $message['error'] = " veiller remplir tout les champs du formulaire ";
        }
        $form = new Form();
        $form->debuForm('post', '#')
            ->ajoutLabelFor('titre', 'Titre:')
            ->ajoutInput('text', 'titre', ['class' => 'form-control', 'required' => true, 'placeholder' => 'info'])
            ->textArea('descriptions', '', ['class' => 'form-control my-1', 'placeholder' => 'Descriptions larticle'])
            ->ajoutButon('Ajouter', ['class' => 'btn btn-primary '])
            ->formFin();
        return $this->render('/article/register', ['form' => $form->create(), 'message' => $message]);
    }


    public function delete()
    {
        // Vérifier si le paramètre 'p' est défini dans l'URL
        if (isset($_GET['p'])) {
            $var = explode('/', $_GET['p']);
            $vart = $var[3];
            if (filter_var($vart, FILTER_VALIDATE_INT)) {
                // Créer une instance du modèle ArticleModel
                $art = new ArticleModel();
                // Rechercher l'article par son ID
                $article = $art->find($vart);
                // Vérifier si l'article existe
                if ($article) {
                    // Si le formulaire a été soumis (méthode POST)
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Si l'utilisateur a confirmé la suppression
                        if (isset($_POST['confirm'])) {
                            // Supprimer l'article
                            $art->delet($article->id);
                            $_SESSION['success'] = "L'article a été bien supprimé";
                            header('Location: /index.php?p=/main/general');
                            exit;
                        } elseif (isset($_POST['cancel'])) {
                            // Si l'utilisateur a annulé la suppression
                            $_SESSION['info'] = "La suppression a été annulée.";
                            header('Location: /index.php?p=/main/general');
                            exit;
                        }
                    }
                    // Créer le formulaire de confirmation
                    $form = new Form();
                    $form->debuForm('post', '#')
                        ->ajoutLabelFor('titre', 'Titre:')
                        ->ajoutInput('number', 'Id', ['class' => 'form-control', 'value' => $article->id, 'readonly' => true])
                        ->ajoutInput('text', 'titre', ['class' => 'form-control', 'value' => $article->titre, 'readonly' => true])
                        ->textArea('descriptions', $article->message, ['class' => 'form-control my-1', 'readonly' => true])
                        ->ajoutButon('Confirmer la suppression', ['class' => 'btn btn-danger', 'name' => 'confirm'])
                        ->ajoutButon('Annuler', ['class' => 'btn btn-success', 'name' => 'cancel'])
                        ->formFin();
                    // Rendre la vue 'delete' avec le formulaire
                    return $this->render('article/delete', ['form' => $form->create()]);
                } else {
                    $_SESSION['warning'] = "L'article n'existe pas.";
                    header('Location: /index.php?p=/main/general');
                    exit;
                }
            }
        }
    }

    public function editer()
    {

        // Vérification si le paramètre 'p' est bien défini dans POST
        if (isset($_GET['p'])) {
            // Extraire l'ID de l'article à partir de l'URL
            $var = explode('/', $_GET['p']);
            $vart = $var[3];  // Assure-toi que cet indice est correct
            // Vérifier si c'est un ID valide (entier)
            if (filter_var($vart, FILTER_VALIDATE_INT)) {
                $art = new ArticleModel();
                $article = $art->find($vart);  // Utilise l'ID pour trouver l'article
                if ($article) {
                    $form = new Form();
                    $form->debuForm('post', '#')
                        ->ajoutLabelFor('titre', 'Titre:')
                        ->ajoutInput('number', 'Id', ['class' => 'form-control', 'value' => $article->id, 'readonly' => true])
                        ->ajoutInput('text', 'titre', ['class' => 'form-control', 'value' => $article->titre, 'required' => true])
                        ->textArea('descriptions', $article->message, ['class' => 'form-control my-1', 'required' => true])
                        ->ajoutlink('/index.php?p=/main/general', 'Retour', ['class' => 'btn btn-success'])
                        ->ajoutlink("/index.php?p=/article/update/$article->id", 'Modifier', ['class' => 'btn btn-warning'])

                        ->formFin();
                    // Rendre la vue 'editer' avec le formulaire
                    return $this->render('article/editer', ['form' => $form->create()]);
                } else {
                    // Si l'article n'existe pas
                    $_SESSION['warning'] = "L'article n'existe pas.";
                    header('Location: /index.php?p=/main/index');
                    exit;
                }
            }
        }
    }






}