<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');

// Gestion de la soumission du formulaire
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title) || empty($description)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        $username = $_SESSION['username'];
        if (addTicket($title, $description, $username)) {
            $message = "✅ Ticket créé avec succès.";
            header("Location: ticket.php?success=1");
            exit;
        } else {
            $message = "❌ Une erreur est survenue lors de la création du ticket.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un ticket</title>
    <link rel="stylesheet" href="css1.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            color: #474145;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form textarea {
            height: 150px;
            resize: vertical;
        }

        form button {
            background-color: #ff5c5c;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #e84141;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: 500;
            color: #333;
        }

        .message.error {
            color: #d9534f;
        }

        .message.success {
            color: #5cb85c;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>Création de ticket</h1>

    
    <div class="form-container">
        <form method="POST" action="">
            <label for="title">Titre du ticket :</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit">Créer le ticket</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>