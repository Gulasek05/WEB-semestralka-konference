<?php
declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';
use App\Core\Database;
$pdo = (new Database())->getPdo();
$vysledek=$pdo->query('SELECT nazev FROM Role;');
$radky=$vysledek->fetchAll();
foreach ($radky as $radek){
    echo($radek['nazev']."<br>");
}