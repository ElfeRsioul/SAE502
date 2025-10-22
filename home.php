<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="css1.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    .accueil {
        text-align : center;
        margin-top: 40px;
    }
    .action {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
        gap: 30px;
    }
    .action a.click {
        background-color: #ff5c5c;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        padding: 16px 32px;
        font-size: 18px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
   .action a.click:hover {
        background-color: #e84141;
        transform: scale(1.05);
    }
</style>
<body>

    <?php include 'navbar.php' ; ?>

    <div class="accueil">
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> !</h1>
    </div>

    <div class="action">
        <div>
            <a class="click" href="ticket.php">Voir les tickets</a>
        </div>
        <div>
            <a class="click" href="create_ticket.php">Créer un ticket</a>
        </div>
    </div>

</body>
</html>
