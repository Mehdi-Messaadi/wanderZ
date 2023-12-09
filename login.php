<?php

include 'includes/autoloader.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a new instance of MyDatabase
    $db = new DbConnect('localhost', 'root', 'mehdiPMA', 'wanderz');
    $db->connect();
    $pdo = $db->getPDO();

    // Prepare and execute the query
    $sql = "SELECT user_id, email, password FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set the session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];

            // Redirect to a logged-in page
            header("Location: welcome.php");
            exit;
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}
