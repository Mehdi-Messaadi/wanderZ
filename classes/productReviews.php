<?php

class ProductReviews extends Dbh
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

    public function getReviewsByProductSku($productSku)
    {
        $this->connect();
        $sql = "SELECT * FROM reviews WHERE product_sku = :product_sku";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':product_sku', $productSku);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReviewsByUserId($userId)
    {
        $this->connect();
        $sql = "SELECT * FROM reviews WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReviewById($reviewId)
    {
        $this->connect();
        $sql = "SELECT * FROM reviews WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addReview($productSku, $userId, $name, $rating, $reviewTitle, $reviewBody)
    {
        $this->connect();
        $sql = "INSERT INTO reviews (product_sku, user_id, name, rating, review_title, review_body) VALUES (:product_sku, :user_id, :name, :rating, :review_title, :review_body)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':product_sku', $productSku);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_title', $reviewTitle);
        $stmt->bindParam(':review_body', $reviewBody);
        $stmt->execute();
        return $this->pdo->lastInsertId(); // Returns the ID of the newly inserted review
    }


    public function updateReview($reviewId, $newText)
    {
        $this->connect();
        $sql = "UPDATE reviews SET review_body = :newText WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':newText', $newText);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Returns the number of rows affected
    }

    public function deleteReview($reviewId)
    {
        $this->connect();
        $sql = "DELETE FROM reviews WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Returns the number of rows affected
    }
}
