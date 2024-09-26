<?php
namespace App\Core;

class Form
{

    private $formCode = '';

    public function create()
    {
        return $this->formCode;
    }
    public function validate(array $form, array $champs)
    {
        foreach ($champs as $value) {
            if (!isset($form[$value]) || empty($form[$value])) {
                return false;
            }
            return true;
        }
    }

    public function ajoutAttributes(array $attributes)
    {
        $str = '';

        $courts = ['checked', 'desabled', 'readonly', 'mutliple', 'required', 'autofocus', 'selected'];
        foreach ($attributes as $key => $value) {
            if (in_array($key, $courts) && $value == true) {
                $str .= " $key";
            } else {
                $str .= " $key=\"$value\"";
            }
        }
        return $str;
    }

    public function debuForm(string $methode = 'post', string $action = '#', array $attributes = [])
    {

        //on crée la balise form 
        $this->formCode .= "<form action='$action' method='$methode'";
        //ajoutes les attributes eventuel
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';

        return $this;
    }
    public function formFin()
    {
        $this->formCode .= '</form>';
        return $this;
    }
    public function ajoutLabelFor(string $for, string $texte, array $attributes = [])
    {
        //ouver la balise label 
        $this->formCode .= "<label for='$for'";
        // on ajoute les attributes
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) : '';
        //on ajout le text
        $this->formCode .= "> $texte</label>";
        return $this;
    }

    public function textArea(string $nom, string $valeur = '', array $attributes = [])
    {
        // Ouvrir la balise textarea
        $this->formCode .= "<textarea name='$nom'";
        // Ajouter les attributs
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) : '';
        // Ajouter le texte
        $this->formCode .= ">$valeur</textarea>";
        return $this;
    }


    public function ajoutlink(string $lien, $texte, array $attributes = [])
    {
        $this->formCode .= "<a href='$lien' ";
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        $this->formCode .= " $texte </a>";
        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributes = [])
    {
        $this->formCode .= "<input type='$type'  name='$nom' ";
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        return $this;
    }
    public function ajoutSelect(string $nom, array $option, array $attributes = [])
    {
        $this->formCode .= "<select name='$nom'";
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        $selectedValue = isset($attributes['selected']) ? $attributes['selected'] : null;
        foreach ($option as $key => $value) {
            $isSelected = ($key == $selectedValue) ? ' selected' : '';
            $this->formCode .= "<option value='$key'    $isSelected >$value</option>";
        }
        $this->formCode .= "</select>";
        return $this;
    }
    public function ajoutButon(string $texte, array $attributes = [])
    {
        $this->formCode .= "<button";
        $this->formCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        $this->formCode .= " $texte</button>";
        return $this;
    }

}
