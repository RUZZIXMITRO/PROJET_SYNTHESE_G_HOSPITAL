<?php
require_once 'connection.php';
$db = new Database();
$conn = $db->connect();

session_start();

if (!isset($_SESSION['ID_STG'])) {
    die("Vous devez être connecté en tant que stagiaire.");
}

$id_stg = $_SESSION['ID_STG'];
 // ← à remplacer dynamiquement avec $_SESSION['id_stg'] si tu fais un login plus tard

// Vérifier si une demande existe déjà en attente ou validée
$check = $conn->prepare("SELECT * FROM poser WHERE ID_STG = ? AND ETAT_POSER = 'En attente'");
$check->execute([$id_stg]);

if ($check->rowCount() > 0) {
    echo "⏳ Une demande est déjà en attente.";
} else {
    $stmt = $conn->prepare("INSERT INTO poser (ID_STG) VALUES (?)");
    $stmt->execute([$id_stg]);
    echo "✅ Demande envoyée avec succès.";
}
?>
