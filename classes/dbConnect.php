<?php

class DbConnect extends Dbh
{
    public function connect()
    {
        $dsn = 'mysql:host=' . $this->getHost() . ';dbname=' . $this->getDbName();
        try {
            $this->pdo = new PDO($dsn, $this->getUser(), $this->getPwd());
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
