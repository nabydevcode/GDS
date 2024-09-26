<?php
namespace App\Models;

class ScreneauxModel
{
    public function vues_increment()
    {
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
        $file_jounalier = $file . '-' . date('Y-m-d');
        $this->incrementer($file);
        $this->incrementer($file_jounalier);
    }

    public function incrementer(string $fichier)
    {
        $directory = dirname($fichier);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // Crée le répertoire si nécessaire
        }
        $compteur = 1;
        if (file_exists($fichier)) {
            $compteur = (int) file_get_contents($fichier);
            $compteur++;
        }
        file_put_contents($fichier, $compteur);
    }

    public function recuperer_vues(): int
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur';
        $nombre = 0;
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if (is_numeric($content)) { // Vérifie que le contenu est bien un nombre
                $nombre = (int) $content;
            }
        }
        return $nombre;
    }

    public function vues_par_mois(int $annee, int $mois): int
    {
        $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur-' . $annee . '-' . $mois . '-' . '*';
        $files = glob($file);
        $total = 0;
        foreach ($files as $data) {
            $total += (int) file_get_contents($data);
        }
        return $total;
    }

    public function details_vues_par_mois(int $annee, int $mois): array
    {
        $mois = str_pad($mois, 2, '0', STR_PAD_LEFT);
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur-' . $annee . '-' . $mois . '-' . '*';
        $files = glob($file);
        $visite = [];
        foreach ($files as $data) {
            $parties = explode('-', basename($data));
            $visite[] = [
                'annee' => $parties[1],
                'mois' => $parties[2],
                'jour' => $parties[3],
                'total' => (int) file_get_contents($data)
            ];
        }
        return $visite;
    }


    function genererhorair(array $creneaux, array $semaine)
    {
        // Tableau des jours de la semaine


        $output = '';
        // Parcourir chaque jour
        foreach ($creneaux as $index => $jour) {
            $phrase = [];
            // Si le jour est fermé (tableau vide)
            if (empty($jour)) {
                $output .= "<p>{$semaine[$index]} : fermé</p>";
            } else {
                // Parcourir les créneaux horaires de la journée
                foreach ($jour as $value) {
                    // Vérifier que chaque créneau a exactement 2 éléments (ouverture et fermeture)
                    if (is_array($value) && count($value) === 2) {
                        $ouverture = $value[0];
                        $fermeture = $value[1];
                        $phrase[] = "de <strong>{$ouverture}h</strong> à <strong>{$fermeture}h</strong>";
                    }
                }
                // Joindre tous les créneaux de la journée avec "et"
                $output .= "<p>{$semaine[$index]} : " . implode(' e t ', $phrase) . "</p>";
            }
        }

        return $output;
    }


    public function genererhoraire(array $creneaux)
    {

        $phrase = [];
        foreach ($creneaux as $key => $jourCreneaux) {
            if (count($jourCreneaux) === 0) {
                // Si le jour est fermé
                $phrase[] = " fermé ";
            } else {
                $creneauxJour = [];
                foreach ($jourCreneaux as $creneau) {
                    if (is_array($creneau) && count($creneau) === 2) {
                        // Gestion des heures de début et de fin
                        $debut = isset($creneau[0]) && $creneau[0] !== '' ? $creneau[0] . "h" : "fermé";
                        $fin = isset($creneau[1]) && $creneau[1] !== '' ? $creneau[1] . "h" : "fermé";
                        $creneauxJour[] = "de <strong>$debut</strong> à <strong>$fin</strong>";
                    } else {
                        // Si le créneau n'est pas correct ou vide, afficher "fermé"
                        $phrase[] = " fermé ";
                    }
                }
                $phrase[] = " Ouvert " . implode(' et ', $creneauxJour);
            }

        }

        // Retourner toutes les informations sous forme de chaîne
        return $phrase;
    }
    // Fonction pour vérifier si le magasin est ouvert pour un jour et une heure donnés
    public function verifierOuverture(int $jour, $heure, array $cre)
    {

        foreach ($cre[$jour] as $key => $value) {
            if (count($value) !== 0) {
                $debut = $value[0];
                $fin = $value[1];
                if ($heure >= $debut && $heure < $fin) {
                    return true;
                }
            }
        }
        return false;
    }





}
