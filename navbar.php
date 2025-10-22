<?php
if (!isset($isAdmin)) {
    $isAdmin = false; // Valeur par défaut si non défini
}
?>
<style>
    .navbar {
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        padding: 12px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-weight: 500;
        font-size: 16px;
        transition: color 0.2s ease;
    }

    .navbar a:hover {
        color: #ffd700;
    }

    .navbar .logout {
        background-color: #ff5c5c;
        padding: 8px 14px;
        border-radius: 4px;
        font-weight: bold;
        transition: background-color 0.2s ease;
    }

    .navbar .logout:hover {
        background-color: #e84141;
    }
</style>
<div class="navbar">
    <div>
        <a href="home.php">Accueil</a>
        <a href="ticket.php">Voir les tickets</a>
        <?php if ($isAdmin): ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
    </div>
    <div>
        <a class="logout" href="logout.php">Se déconnecter</a>
    </div>
</div>