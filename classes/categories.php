<?php

class Categories extends Dbh
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

    public function getAllCategories()
    {
        $this->connect();
        $sql = "SELECT * FROM categories";
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

    public function getCategoryByTitle($categoryTitle)
    {
        $this->connect();
        $sql = "SELECT * FROM categories WHERE category_title = :categoryTitle";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoryTitle', $categoryTitle);
        $stmt->execute();
        return $stmt->fetch();
    }
}
