<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');
$tickets = getAllTickets();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="css1.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .ticket-list {
            max-width: 900px;
            margin: 0 auto;
        }

        .ticket {
            position: relative;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            color: #474145;
        }

        .edit-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #888;
            font-size: 18px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .edit-icon:hover {
            color: #ff5c5c;
        }

        .ticket-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .ticket-meta {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .ticket-description {
            font-size: 16px;
        }

        .no-tickets {
            text-align: center;
            color: #888;
            font-style: italic;
        }
        .success-message {
            text-align: center;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>
    
    <h1>Liste des tickets</h1>

    <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<p class="success-message">✅ Ticket créé avec succès.</p>';
    }
    ?>

    <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
    <p style="text-align: center; color: green; font-weight: bold;">✅ Ticket mis à jour avec succès.</p>
    <?php endif; ?>


    <div class="ticket-list">
        <?php if (empty($tickets)): ?>
            <p class="no-tickets">Aucun ticket pour le moment.</p>
        <?php else: ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket">
                    <?php if ($ticket['user_id'] == $_SESSION['user_id']): ?>
                        <a href="edit_ticket.php?id=<?= $ticket['id'] ?>" class="edit-icon" title="Modifier le ticket">✏️</a>
                    <?php endif; ?>

                    <div class="ticket-title"><?= htmlspecialchars($ticket['title']) ?></div>
                    <div class="ticket-meta">
                        Créé par <strong><?= htmlspecialchars($ticket['username']) ?></strong>
                        le <?= date('d/m/Y à H:i', strtotime($ticket['created_at'])) ?>
                    </div>
                    <div class="ticket-description"><?= nl2br(htmlspecialchars($ticket['description'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>