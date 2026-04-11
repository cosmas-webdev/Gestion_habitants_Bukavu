<?php
/**
 * Configuration de la base de données
 * ---------------------------------
 * Fichier séparé pour une meilleure maintenabilité et sécurité
 */

// Constantes de configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'mydb');
define('DB_USER', 'root');
define('DB_PASS', ''); // À remplacer par un mot de passe en production

// Options PDO supplémentaires recommandées
$pdo_options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // Désactive l'émulation des requêtes préparées
    PDO::ATTR_PERSISTENT         => false // Évite les connexions persistantes (sécurité)
];

try {
    // Création de l'instance PDO
    $db = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", // utf8mb4 pour support complet Unicode
        DB_USER,
        DB_PASS,
        $pdo_options
    );
} catch (PDOException $e) {
    // En production, ne pas afficher le message d'erreur complet
    error_log('Database connection error: ' . $e->getMessage());

    // Message générique pour l'utilisateur
    die("Impossible de se connecter à la base de données. Veuillez réessayer plus tard.");
}

// Fonction utile pour les requêtes (optionnelle)
function db_query(string $sql, array $params = []) {
    global $db;
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}
