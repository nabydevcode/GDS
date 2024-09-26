<?php


class Tuto
{
    private $fromCode = '';

    public function create()
    {
        return $this->fromCode;
    }
    public function validate(array $form, array $champs)
    {
        foreach ($champs as $key => $value) {
            if (isset($form[$value]) || empty($form[$value])) {
                return false;
            }
            return true;
        }
    }
    public function ajoutAttributes(array $attributes)
    {
        $str = '';
        $courts = ['checked', 'desabled', 'readonly', 'mutliple', 'required', 'autofocus'];
        foreach ($attributes as $key => $value) {
            if (in_array($key, $courts) || $value == true) {
                $str .= " $key";
            } else {
                $str .= " $key='$value'";
            }
        }
        return $str;
    }
    public function beginForm(string $methode = 'post', string $action = '#', array $attributes = [])
    {
        //on ouvre la balise forme 
        $this->fromCode .= "<form $action $action";
        //on ajoute les attribus si possible  et on ferme la balise 
        $this->fromCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        return $this;
    }
    public function endForm()
    {
        $this->fromCode .= " </form>";
        return $this;
    }
    public function ajouteLabelfor(string $for, string $name, array $attributes = [])
    {
        $this->fromCode .= "<label for='$for'";
        $this->fromCode .= $attributes ? $this->ajoutAttributes($attributes) : '';
        $this->fromCode .= "> $name</label>";
        return $this;
    }
    public function addInpute(string $type, string $name, array $attributes = [])
    {
        $this->fromCode .= "<input type='$type'  name='$name'";
        $this->fromCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        return $this;
    }
    public function addSelect(string $name, array $attributes = [])
    {
        $this->fromCode .= "<select name=' $name'";
        $this->fromCode .= $attributes ? $this->ajoutAttributes($attributes) . '>' : '>';
        $this->fromCode .= "</select>";
        return $this;
    }
}