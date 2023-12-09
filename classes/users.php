<?php

class Users extends dbh
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

    public function getUserByID($user_id)
    {
        $this->connect();
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateUser($user_id, $email, $first_name, $last_name, $billing_address, $shipping_address, $phone_number)
    {
        $this->connect();

        if ($email && $this->emailExistsForOtherUser($email, $user_id)) {
            throw new Exception("Email already exists.");
        }

        try {
            $sql = "UPDATE users SET 
                    email = COALESCE(:email, email), 
                    first_name = COALESCE(:first_name, first_name),
                    last_name = COALESCE(:last_name, last_name),
                    billing_address = COALESCE(:billing_address, billing_address),
                    shipping_address = COALESCE(:shipping_address, shipping_address),
                    phone_number = COALESCE(:phone_number, phone_number)
                    WHERE user_id = :user_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':billing_address', $billing_address);
            $stmt->bindParam(':shipping_address', $shipping_address);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function registerUser($email, $password, $first_name, $last_name, $billing_address, $shipping_address, $phone_number)
    {
        $this->connect();

        if ($this->emailExists($email)) {
            throw new Exception("Email already exists.");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (email, password, first_name, last_name, billing_address, shipping_address, phone_number) 
                    VALUES (:email, :password, :first_name, :last_name, :billing_address, :shipping_address, :phone_number)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':billing_address', $billing_address);
            $stmt->bindParam(':shipping_address', $shipping_address);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error during registration: " . $e->getMessage());
        }
    }

    private function emailExists($email)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function emailExistsForOtherUser($email, $user_id)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
