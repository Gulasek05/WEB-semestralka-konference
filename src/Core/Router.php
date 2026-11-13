<?php
namespace App\Core;

use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\ErrorController;
class Router
{
    // tabulka rout: cesta => [třída controlleru, název metody]
    private array $routes = [
        'home' => [HomeController::class, 'index'],
        'try' => [HomeController::class, 'test'],
        'register'=>[HomeController::class, 'register'],
        'login'=>[HomeController::class, 'login'],
        'register' => [AuthController::class, 'register'],
        'login' => [AuthController::class, 'login'],
        'logout' => [AuthController::class, 'logout'],
        'test-admin' => [HomeController::class, 'index', ['admin']],
        '404' => [ErrorController::class, 'error404'],
        '403' => [ErrorController::class, 'error403'],
        // další cesty přidáš později (login, register...)
    ];

    public function dispatch(): void
    {
        // 1. Z $_SERVER['REQUEST_URI'] vezmi jen cestu (parse_url + PHP_URL_PATH)
        $cesta = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

        // 2. Odstraň lomítka z okrajů (trim); prázdná cesta znamená 'home'
        $cesta=trim($cesta,'/');
        if ($cesta===''){
            $cesta='home';
        }
        // 3. Existuje cesta v $this->routes?
        if (isset($this->routes[$cesta])) {
            $role = $this->routes[$cesta][2] ?? null;
            if($role){
                $user =$_SESSION['user'] ?? null;
                if($user){
                    if($user['role']==$role){
                        [$trida, $metoda] = $this->routes[$cesta];
                        $objekt = new $trida();
                        $objekt->$metoda();
                    }
                    else{
                        http_response_code(403);
                        $objekt = new ErrorController();
                        $objekt->error403();
                    return;
                    }
                }
                else{
                    header('Location: /login');
                    exit;
                }
            }
            else{
            [$trida, $metoda] = $this->routes[$cesta];
            $objekt = new $trida();
            $objekt->$metoda();
            }
        } else {
            // 5. Neznámá cesta: kód 404 a krátká zpráva
                http_response_code(404);
                $objekt = new ErrorController();
                $objekt->error404();
        }
    }
}