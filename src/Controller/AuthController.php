<?php
namespace App\Controller;

use App\Core\Controller;
use App\Model\RoleModel;
use App\Model\UserModel;

/**
 * Registrace a přihlašování uživatelů.
 */
class AuthController extends Controller
{
    /** Registrace: GET zobrazí formulář, POST zpracuje odeslaná data. */
    public function register()
    {
        // GET: jen zobraz prázdný formulář a skonči
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->render('auth/register.html.twig');
            return;
        }
        // POST: načti hodnoty z formuláře
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $heslo = $_POST['password'] ?? '';
        $heslo2 = $_POST['password_again'] ?? '';

        $chyby = [];
        $userModel = new UserModel();

        // Validace: každou chybu přidej do pole $chyby
        if ($username === '' || $email === '') {
            $chyby[] = 'Vyplňte uživatelské jméno i e-mail.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $chyby[] = 'E-mail nemá platný formát.';
        }
        if (mb_strlen($heslo)<8){
            $chyby[]= 'Heslo musí mít alespoň 8 znaků.';
        }
        if ($heslo != $heslo2){
            $chyby[]= 'Hesla se neshodují';
        }
        if ($userModel->findByEmail($email) || $userModel->findByUsername($username) ){
            $chyby[]= 'Email nebo heslo už existují';
        }
        // TODO: e-mail už existuje (findByEmail vrátí řádek, ne false)
        // TODO: uživatelské jméno už existuje (findByUsername)

        // Uložení, pokud nejsou žádné chyby
        if (empty($chyby)) {
            $roleId = (new RoleModel())->findIdByName('autor');
            if ($roleId === false) {
                $chyby[] = 'Role autor v databázi neexistuje.';
            }
        }
        if (empty($chyby)) {
            $hash = password_hash($heslo, PASSWORD_DEFAULT);
            $userModel->create($username, $email, $hash, $roleId);
            header('Location: /login');
            exit;
        }

        // Chyby: zobraz formulář znovu i s tím, co uživatel zadal
        $this->render('auth/register.html.twig', [
            'chyby' => $chyby,
            'username' => $username,
            'email' => $email,
        ]);
    }
}