<?php
namespace App\Controller;

use App\Core\Controller;

class ErrorController extends Controller
{
    //vykreslení stránek
    public function error404()
    {
        $this->render('errors/404.html.twig', ['nadpis' => 'Not found']);
    }
    public function error403(){
        $this->render('errors/403.html.twig', ['nadpis' => 'No access']);
    }
}