<?php
namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    //vykreslení stránek
    public function index()
    {
        $this->render('home/index.html.twig', ['nadpis' => 'Vítejte']);
    }
    public function register(){
        $this->render('auth/register.html.twig', []);
    }
    public function login(){
        $this->render('auth/login.html.twig', []);
    }
    public function test(){
       echo ('poser se');
    }
}