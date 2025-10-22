<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$ticketId = $_GET['id'] ?? null;
if (!$ticketId || !is_numeric($ticketId)) {
    die("ID de ticket invalide.");
}

$ticket = getTicket($ticketId);
if (!$ticket) {
    die("Ticket introuvable.");
}

// Vérification que l'utilisateur connecté est bien l'auteur du ticket
if ($ticket['user_id'] != $_SESSION['user_id']) {
    die("Vous n'avez pas l'autorisation de modifier ce ticket.");
}

$message = '';

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title) || empty($description)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        $db = getDB();
        $stmt = $db->prepare("UPDATE tickets SET title = :title, description = :description WHERE id = :id");
        if ($stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':id' => $ticketId
        ])) {
            header("Location: ticket.php?updated=1");
            exit;
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un ticket</title>
    <link rel="stylesheet" href="css1.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        h1 {
            text-align: center;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
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
        button:hover {
            background-color: #e84141;
        }
        .message {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Modifier un ticket</h1>

    <div class="form-container">
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($ticket['title']) ?>" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($ticket['description']) ?></textarea>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>