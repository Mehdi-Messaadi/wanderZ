<?php

class ViewProducts extends Dbh
{
    protected function connect()
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

    public function getAllProducts()
    {
        $this->connect();
        $sql = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function executeQuery($query, $params = [])
    {
        $this->connect();
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getProductById($productId)
    {
        $this->connect();
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}
