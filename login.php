<?php
session_start(); 
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user_id and hashed password
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User exists, fetch the data
            $stmt->bind_result($user_id, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Password is correct, store user_id and email in session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;

                // Set admin_logged_in flag for admin users
                if ($user_id == 50 || strpos($email, '@admin.net') !== false) {
                    $_SESSION['admin_logged_in'] = true;
                    echo "<script>alert('Login successful! Welcome, Admin.'); window.location.href='index.php';</script>";
                } else {
                    $_SESSION['admin_logged_in'] = false;
                    echo "<script>alert('Login successful! Welcome to Azul Cosmetics.'); window.location.href='index.php';</script>";
                }
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.'); window.location.href='azul-login.html';</script>";
            }
        } else {
            echo "<script>alert('No user found with that email address.'); window.location.href='azul-login.html';</script>";
        }
    } else {
        echo "<script>alert('Database error. Please try again later.'); window.location.href='azul-login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

