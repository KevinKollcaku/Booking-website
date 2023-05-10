<?php

class Database
{
    private PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql): false|PDOStatement
    {
        try {
            return Application::$APP->getDb()->pdo->prepare($sql);
        } catch (\Throwable $th) {
            exit("fatale error with the database");
        }
        
    }
}