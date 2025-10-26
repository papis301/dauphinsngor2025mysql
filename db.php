<?php
// Activer le rapport d’erreurs (utile en développement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$host = "localhost";      // ou l’adresse de ton serveur MySQL
$user = "root";           // ton utilisateur MySQL
$password = "";           // ton mot de passe MySQL
$database = "dauphinsngormysql"; // nom de ta base de données

try {
    // Connexion avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    // Définir le mode d’erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d’erreur de connexion
    die("❌ Échec de connexion à la base de données : " . $e->getMessage());
}
?>
