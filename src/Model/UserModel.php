<?php
namespace App\Model;

use App\Core\Database;
use PDO;

/**
 * Práce s tabulkou Uzivatel.
 */
class UserModel
{
    private PDO $pdo;

    public function __construct()
    {
        // stejné připojení, jaké jsi dřív zkoušel v index.php
        $this->pdo = (new Database())->getPdo();
    }

    /** Najde uživatele podle e-mailu. Vrátí řádek, nebo false, pokud neexistuje. */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT u.*, r.nazev AS role
                                    FROM Uzivatel u
                                    JOIN Role r ON r.id = u.role_id
                                    WHERE u.email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /** Najde uživatele podle uživatelského jména. */
    public function findByUsername(string $username): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Uzivatel WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
        
    }

    /** Vloží nového uživatele. Heslo sem přichází už zahashované. */
    public function create(string $username, string $email, string $hash, int $roleId): void
    {
         $stmt = $this->pdo->prepare('INSERT INTO Uzivatel (username, email, heslo_hash, role_id) VALUES (:username, :email, :hash, :roleId)');
         $stmt -> execute([
         'username' => $username,
         'email' => $email,
         'hash' => $hash,
         'roleId'=>$roleId]);
    }
}