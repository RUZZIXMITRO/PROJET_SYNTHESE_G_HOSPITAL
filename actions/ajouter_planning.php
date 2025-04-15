<?php
require_once '../connection.php';

$db = new Database();
$conn = $db->connect();

$id_stg = $_POST['id_stg'];
$id_ser = $_POST['id_ser'];
$date_deb = $_POST['date_deb'];
$date_fin = $_POST['date_fin'];

if (!$id_stg || !$id_ser || !$date_deb || !$date_fin) {
    die("Tous les champs sont obligatoires.");
}

try {
    $stmt = $conn->prepare("INSERT INTO planning (ID_STG, ID_SER, DATE_DEB_STG, DATE_FIN_STG) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_stg, $id_ser, $date_deb, $date_fin]);

    header("Location: ../plannings.php?message=ajout");

    exit;

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
