<?php
require_once '../connection.php';
$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$etat = $_GET['etat'] ?? null;

if (!$id || !in_array($etat, ['Validée', 'Refusée'])) {
    die("Paramètres invalides.");
}

$stmt = $conn->prepare("UPDATE poser SET ETAT_POSER = ? WHERE ID_MSG = ?");
$stmt->execute([$etat, $id]);

header("Location: ../attestations.php?message=etat");
exit;
