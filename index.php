<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e1cf95, #BABD95); height: 100vh; display: flex; justify-content: center; align-items: center; }

        .container { background-color: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.2); width: 100%; max-width: 400px; }

        h2 { text-align: center; margin-bottom: 20px; }

        form { margin-bottom: 30px; }

        input[type="text"], input[type="password"] { width: 100%; padding: 12px 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; }

        input[type="submit"] { width: 100%; padding: 12px; background-color: #4a90e2; border: none; border-radius: 8px; color: white; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }

        input[type="submit"]:hover { background-color: #357ABD; }

        .error, .success { text-align: center; margin-bottom: 10px; font-weight: bold; }

        .error { color: red; }

        .success { color: green; }

        .divider { border-top: 1px solid #ddd; margin: 30px 0; }
    </style>
</head>
<body>

<div class="container">
    <h2>Connexion</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Identifiants invalides.</p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>

    <div class="divider"></div>

    <h2>Créer un compte</h2>

    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
        <p class="success">Compte créé avec succès !</p>
    <?php elseif (isset($_GET['register']) && $_GET['register'] === 'exists'): ?>
        <p class="error">Nom d'utilisateur déjà utilisé.</p>
    <?php elseif (isset($_GET['register']) && $_GET['register'] === 'error'): ?>
        <p class="error">Erreur lors de l'inscription.</p>
    <?php endif; ?>

    <form action="register.php" method="post">
        <input type="text" name="new_username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="new_password" placeholder="Mot de passe" required>
        <input type="submit" value="Créer un compte">
    </form>
</div>

</body>
</html>
