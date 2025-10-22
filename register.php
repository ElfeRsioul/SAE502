<?php
require 'db.php';

if (isset($_POST['new_username'], $_POST['new_password'])) {
    $username = trim($_POST['new_username']);
    $password = trim($_POST['new_password']);

    if (getUser($username)) {
        // L'utilisateur existe déjà
        header("Location: index.php?register=exists");
        exit;
    }

    $success = addUser($username, $password, 'user');

    if ($success) {
        header("Location: index.php?register=success");
    } else {
        header("Location: index.php?register=error");
    }
} else {
    header("Location: index.php?register=error");
}
exit;
?>
