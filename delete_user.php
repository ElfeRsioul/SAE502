<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['username']) && $_GET['username'] !== $_SESSION['username']) {
    deleteUser($_GET['username']);
}

header("Location: admin.php");
exit;
?>
