<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #4a90e2;
            color: white;
        }

        .actions a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        a.back {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #4a90e2;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Gestion des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td class="actions">
                    <?php if ($user['username'] !== $_SESSION['username']): ?>
                        <a href="delete_user.php?username=<?= urlencode($user['username']) ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                    <?php else: ?>
                        (vous)
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a class="back" href="home.php">← Retour à l'accueil</a>

</body>
</html>
