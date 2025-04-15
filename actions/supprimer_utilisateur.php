<?php
require_once '../connection.php';

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$role = $_GET['role'] ?? null;

if (!$id || !$role) {
    die("Paramètres manquants.");
}

try {
    if ($role === 'stagiaire') {
        $stmt = $conn->prepare("DELETE FROM stagiaire WHERE ID_STG = ?");
    } elseif ($role === 'encadrant') {
        $stmt = $conn->prepare("DELETE FROM encadrant WHERE ID_ENC = ?");
    } else {
        die("Rôle invalide.");
    }

    $stmt->execute([$id]);

    header("Location: ../admin.php?message=suppression");

    exit;

} catch (PDOException $e) {
    die("Erreur lors de la suppression : " . $e->getMessage());
}
