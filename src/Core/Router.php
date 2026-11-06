<?php
namespace App\Core;

use App\Controller\HomeController;

class Router
{
    // tabulka rout: cesta => [třída controlleru, název metody]
    private array $routes = [
        'home' => [HomeController::class, 'index'],
        'o_nas' => [HomeController::class, 'o_nas'],
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
            // 4. Rozlož dvojici na $trida a $metoda a zavolej ji (jako u psa)
            [$trida, $metoda] = $this->routes[$cesta];
            $objekt = new $trida();
            $objekt->$metoda();
        } else {
            // 5. Neznámá cesta: kód 404 a krátká zpráva
            http_response_code(404);
            echo('néznámá stránka');
        }
    }
}