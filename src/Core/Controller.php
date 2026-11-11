<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
    }

    protected function render(string $sablona, array $data = []): void
    {
        echo $this->twig->render($sablona, $data);
    }
}