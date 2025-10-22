<?php
session_start();
require 'db.php';

// Vérifie si les champs sont remplis
if (isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = getUser($username);

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: home.php");
        exit;
    } else {
        // Mauvais identifiants
        header("Location: index.php?error=1");
        exit;
    }
} else {
    // Champs manquants
    header("Location: index.php?error=1");
    exit;
}
?>
