<?php
class Database{
    private $pdo;
    private $dsn = 'mysql:host=db;dbname=konference;charset=utf8mb4';
    private $user = 'app';
    private $password = 'app';

    public function __construct(){
        $this->pdo = new PDO($this->dsn,
        $this->user,
        $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getPdo(){
        return $this->pdo;
    }
}

