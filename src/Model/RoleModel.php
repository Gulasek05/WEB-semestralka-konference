<?php
namespace App\Model;

use App\Core\Database;
use PDO;

class RoleModel {
    private PDO $pdo;
    /** Práce s tabulkou Role. */
    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }
    /** Vrátí id role podle názvu, nebo false, pokud role neexistuje. */
    public function findIdByName(string $nazev) :int|false
    {
        $stmt = $this->pdo->prepare('SELECT id FROM Role WHERE nazev = :nazev');
        $stmt->execute(['nazev' => $nazev]);
        $radek = $stmt->fetch();
        $id =(int)$radek['id'];
        return $id;
    }

}