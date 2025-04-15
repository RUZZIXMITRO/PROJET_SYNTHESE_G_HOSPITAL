<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['ID_STG'])) {
    die("⛔ Accès refusé. Veuillez vous connecter.");
}

$db = new Database();
$conn = $db->connect();
$id_stg = $_SESSION['ID_STG'];

// Récupérer les demandes d’attestation du stagiaire connecté
$stmt = $conn->prepare("SELECT * FROM poser WHERE ID_STG = ?");
$stmt->execute([$id_stg]);
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Stagiaire</title>
</head>
<body>
    <h2>👋 Bienvenue <?= $_SESSION['NOM_STG'] ?? '' ?> <?= $_SESSION['PRN_STG'] ?? '' ?></h2>

    <h3>📄 Mes demandes d’attestation</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Date</th>
            <th>État</th>
            <th>Action</th>
        </tr>
        <?php foreach ($demandes as $demande): ?>
        <tr>
            <td><?= $demande['DATE_POSER'] ?></td>
            <td><?= $demande['ETAT_POSER'] ?></td>
            <td>
                <?php if ($demande['ETAT_POSER'] === 'Validée'): ?>
                    <a href="attestation_pdf.php?id=<?= $demande['ID_MSG'] ?>" target="_blank">📥 Télécharger PDF</a>
                <?php elseif ($demande['ETAT_POSER'] === 'En attente'): ?>
                    ⏳ En attente
                <?php else: ?>
                    ❌ Refusée
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <form action="demander_attestation.php" method="post">
        <button type="submit">➕ Faire une nouvelle demande</button>
    </form>

    <br><a href="logout.php">Se déconnecter</a>
</body>
</html>
