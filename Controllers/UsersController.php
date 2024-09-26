<?php
namespace App\Controllers;
use App\Core\Form;
use App\Models\UserModel;

class UsersController extends Controller
{
    public function login()
    {

        if (isset($_POST['email'], $_POST['password'])) {
            $email = strip_tags(trim($_POST['email']));
            $password = strip_tags(trim($_POST['password']));
            $user = new UserModel();
            $pers = $user->finbyEmail($email);
            if ($pers) {
                if (password_verify($password, $pers->password)) {
                    $_SESSION['user'] = [$pers->id, $pers->email, $pers->role];
                    $_SESSION['message'] = "Bienvenue dans mon espace personnel";
                    $_SESSION['visited'] = true;
                    header('Location: /index.php?p=/main/index');
                    exit();
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect";
                    header('Location: /index.php?p=/users/login');
                    exit();
                }
            } else {
                $_SESSION['danger'] = "Vos identifiants ne correspondent à aucun utilisateur";
            }
        }

        $form = new Form();
        $form->debuForm('post', '#', ['class' => 'form', 'id' => 'formulaire'])
            ->ajoutLabelFor('email', 'E-mail:')
            ->ajoutInput('email', 'email', ['class' => 'form-control',])
            ->ajoutLabelFor('password', 'Mot-de-pass:')
            ->ajoutInput('password', 'password', ['class' => 'form-control'])
            ->ajoutButon('Connecte', ['type' => 'submit', 'class' => 'btn btn-primary'])
            ->ajoutlink('/index.php?p=/users/register', 'M\'inscrire', ['class' => 'btn btn-success'])
            ->formFin();
        $this->render('user/login', ['loginForm' => $form->create()]);
    }
    public function register()
    {
        if (isset($_POST['noms'], $_POST['prenoms'], $_POST['email'], $_POST['password'])) {
            $name = strip_tags(trim($_POST['noms']));
            $lastname = strip_tags(trim($_POST['prenoms']));
            $email = strip_tags(trim($_POST['email']));
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emaile = $email;
            }
            $password = strip_tags(trim($_POST['password']));
            $password = password_hash($password, PASSWORD_ARGON2ID);
            $user = new UserModel();
            $user->setName($name)
                ->setPrenoms($lastname)
                ->setEmail($emaile)
                ->setPassword($password)
                ->setRole('user');
            $user->create();
            header('Location: /index.php?p/article/index');
        } else {
            echo " les formulaire est vide ";
        }
        $form = new Form();
        $form->debuForm('post', '#')
            ->ajoutLabelFor('noms', 'Name :')
            ->ajoutInput('text', 'noms', ['class' => 'form-control', 'required' => true])
            ->ajoutLabelFor('prenoms', 'Prenoms :')
            ->ajoutInput('text', 'prenoms', ['class' => 'form-control', 'required' => true])
            ->ajoutLabelFor('email', 'Email:')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Exemple@gmail.com'])
            ->ajoutLabelFor('password', 'Mot de passe:')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'required' => true])
            ->ajoutButon('Register', ['class' => 'btn btn-primary'])
            ->ajoutlink('/index.php?p=/users/login', 'Me Connecter', ['class' => 'btn btn-success'])
            ->formFin();
        return $this->render('user/register', ['form' => $form->create()]);
    }
    public function deconnection()
    {
        session_destroy(); // Détruit la session
        unset($_SESSION); // Supprime toutes les variables de session
        header('Location: /index.php?p=users/login'); // Redirige vers la page de login
        exit(); // Termine le scri

    }
}