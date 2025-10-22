<?php

function getDB() {
    static $db = null;

    if ($db === null) {
        try {
            $db = new PDO('sqlite:database.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            initializeDatabase($db);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    return $db;
}

function initializeDatabase($db) {
    // Table users
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT NOT NULL DEFAULT 'user'
    )");

    // Table tickets
    $db->exec("CREATE TABLE IF NOT EXISTS tickets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_id INTEGER NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
}

//////////////////////////////////////////////////////
//    Fonctions pour les utilisateurs
//////////////////////////////////////////////////////

// Ajouter un utilisateur (mot de passe hashé)
function addUser($username, $password, $role = 'user') {
    $db = getDB();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
    return $stmt->execute([
        ':username' => $username,
        ':password' => $hashedPassword,
        ':role' => $role
    ]);
}

// Supprimer un utilisateur par nom
function deleteUser($username) {
    $db = getDB();

    $stmt = $db->prepare("DELETE FROM users WHERE username = :username");
    return $stmt->execute([':username' => $username]);
}

// Obtenir un utilisateur par nom
function getUser($username) {
    $db = getDB();

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtenir tous les utilisateurs
function getAllUsers() {
    $db = getDB();

    $stmt = $db->query("SELECT id, username FROM users ORDER BY username ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//////////////////////////////////////////////////////
//    Fonctions pour les tickets
//////////////////////////////////////////////////////

// Ajouter un ticket
function addTicket($title, $description, $username) {
    $db = getDB();

    // Trouver l'utilisateur
    $user = getUser($username);
    if (!$user) {
        return false; // utilisateur inexistant
    }

    $stmt = $db->prepare("INSERT INTO tickets (title, description, user_id) VALUES (:title, :description, :user_id)");
    return $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':user_id' => $user['id']
    ]);
}

// Supprimer un ticket par ID
function deleteTicket($ticketId) {
    $db = getDB();

    $stmt = $db->prepare("DELETE FROM tickets WHERE id = :id");
    return $stmt->execute([':id' => $ticketId]);
}

// Obtenir un ticket par ID
function getTicket($ticketId) {
    $db = getDB();

    $stmt = $db->prepare("
        SELECT tickets.*, users.username 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        WHERE tickets.id = :id
    ");
    $stmt->execute([':id' => $ticketId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtenir tous les tickets
function getAllTickets() {
    $db = getDB();

    $stmt = $db->query("
        SELECT tickets.*, users.username 
        FROM tickets 
        JOIN users ON tickets.user_id = users.id 
        ORDER BY tickets.created_at DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>