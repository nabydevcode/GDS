<?php
namespace App\Models;
use App\Core\Db;
use Exception;
use PDOException;


class Model extends Db
{
    protected $table;
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function prepe($sql, array $attributes = null)
    {
        try {
            if ($attributes != null) {
                $query = $this->db->prepare($sql);
                $query->execute($attributes);
                return $query;
            } else {
                $query = $this->db->query($sql);
                return $query;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }


    }

    public function findAll()
    {
        $query = $this->prepe('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }
    public function findbyAll(array $arr)
    {
        $valeurs = [];
        foreach ($arr as $key => $value) {
            $champ = $key;
            $valeurs[] = $value;
        }
        $query = $this->prepe('SELECT * FROM ' . $this->table . ' WHERE ' . $champ . '=?', $valeurs);
        return $query->fetchAll();
    }
    public function find($id)
    {
        $query = $this->prepe('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $query->fetch();
    }
    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];
        foreach ($this as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $champs[] = $key;
                $inter[] = '?';
                $valeurs[] = $value;  // Utiliser $value au lieu de $valeurs
            }
        }
        $lineschamps = implode(',', $champs);
        $linesinter = implode(',', $inter);
        // Exécuter la requête préparée
        $query = $this->prepe('INSERT INTO ' . $this->table . ' (' . $lineschamps . ') VALUES (' . $linesinter . ')', $valeurs);
        return $query;

    }
    public function delette($id)
    {
        return $this->prepe('DELETE FROM ' . $this->table . ' WHERE id=?', $id);
    }
    public function update()
    {
        $champs = [];
        $valeurs = [];

        foreach ($this as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $champs[] = $key;
                $valeurs[] = $value;
            }
        }
        $valeurs[] = $this->id;

        $champsline = implode('=? , ', $champs) . '=?';
        return $this->prepe('UPDATE ' . $this->table . ' SET ' . $champsline . ' WHERE id=? ', $valeurs);
    }
    public function finbyEmail($email)
    {
        $varleurs[] = $email;
        return $this->prepe('SELECT * FROM ' . $this->table . ' WHERE email=? ', $varleurs)->fetch();
    }

    public function delet($id)
    {
        return $this->prepe('DELETE FROM ' . $this->table . ' WHERE id=? ', [$id]);
    }
}