<?php
require_once 'connection.php';

$db = new Database();
$conn = $db->connect();

// Si la connexion fonctionne, on redirige vers une page d'accueil (à adapter si besoin)
header('Location: login.php');
exit;

?>
