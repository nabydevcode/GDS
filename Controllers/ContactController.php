<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Core\Form;
use App\Models\ContactModel;
use App\Models\ScreneauxModel;


define(
    'SCRENNEAUX',
    [
        [[8, 12], [14, 22]],
        [[8, 12], [14, 22]],
        [[8, 12]],
        [[8, 12], [14, 22]],
        [[8, 12], [14, 22]],
        [],
        []
    ]
);
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
class ContactController extends Controller
{

    public function contacter()
    {
        date_default_timezone_set('Europe/paris');
        // Initialisation des variables
        $jours = (int) date('N') - 1; // Valeur par défaut
        $heure = date('G'); // Heure actuelle par défaut
        $email = '';
        $message = '';
        $boll = false;
        // Vérification du formulaire soumis
        if (isset($_POST['form_identifier'])) {
            // Si le formulaire 1 (jour et heure) est soumis
            if ($_POST['form_identifier'] === 'form1') {
                if (isset($_POST['jour'])) {
                    $jours = (int) $_POST['jour']; // Pas besoin de faire -1 ici
                }
                $heure = isset($_POST['heure']) ? (int) $_POST['heure'] : date('G');
                $for = new ScreneauxModel();
                $boll = $for->verifierOuverture($jours, $heure, SCRENNEAUX); // Vérification des créneaux
            }
            // Si le formulaire 2 (email et message) est soumis
            if ($_POST['form_identifier'] === 'form2') {
                $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                $message = strip_tags($_POST['message']);

                $contact = new ContactModel();
                $contact->setEmail($email);
                $contact->setMessage($message);
                $contact->create();
                $email = '';
                $message = '';
                // Logique pour traiter l'email et le message ici
            }
        }
        // Formulaire 1 (jour et heure)
        $form = new Form();
        $form->debuForm('post', '#', ['id' => 'form1']);
        $form->ajoutSelect('jour', SEMAINE, ['class' => 'form-select', 'selected' => $jours]);
        $form->ajoutInput('number', 'heure', ['class' => 'form-control', 'value' => $heure]);
        $form->ajoutInput('hidden', 'form_identifier', ['value' => 'form1']); // Champ caché pour identifier le formulaire
        $form->ajoutButon('Voir si le magasin est ouvert', ['class' => 'btn btn-success']);
        $form->formFin();

        // Formulaire 2 (email et message)
        $form1 = new Form();
        $form1->debuForm('post', '#', ['id' => 'form2']);
        $form1->ajoutLabelFor('email', 'E-mail: ');
        $form1->ajoutInput('email', 'email', ['class' => 'form-control', 'placeholder' => 'exemple@gmail.com', 'required' => true, 'value' => $email]);
        $form1->textArea('message', $message, ['class' => 'form-control my-1', 'placeholder' => 'Votre message']);
        $form1->ajoutInput('hidden', 'form_identifier', ['value' => 'form2']); // Champ caché pour identifier le formulaire
        $form1->ajoutButon('Envoyer', ['class' => 'btn btn-primary']);
        $form1->formFin();

        // Génération des horaires
        $model = new ScreneauxModel();
        $html = $model->genererhoraire(SCRENNEAUX);

        // Rendu de la page avec les deux formulaires
        return $this->render('main/contact', [
            'html' => $html,
            'form' => $form->create(),
            'jours' => $jours,
            'heure' => $heure,
            'boll' => $boll,
            'form1' => $form1->create()
        ]);
    }

}