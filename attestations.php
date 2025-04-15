<?php
require_once 'connection.php';
$db = new Database();
$conn = $db->connect();

// Récupérer les demandes avec les noms des stagiaires
$requete = "
    SELECT p.ID_MSG, s.NOM_STG, s.PRN_STG, p.DATE_POSER, p.ETAT_POSER
    FROM poser p
    JOIN stagiaire s ON s.ID_STG = p.ID_STG
    ORDER BY p.DATE_POSER DESC
";
$demandes = $conn->query($requete)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des attestations</title>
</head>
<body>
    <h1>📄 Demandes d’attestation</h1>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'etat'): ?>
    <div style="background-color: #d1fae5; padding: 10px; color: #065f46; margin-bottom: 20px; border-radius: 5px;">
        ✅ L’état de la demande a bien été mis à jour.
    </div>
<?php endif; ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>Stagiaire</th>
            <th>Date de demande</th>
            <th>État</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($demandes as $demande): ?>
        <tr>
            <td><?= $demande['NOM_STG'] . ' ' . $demande['PRN_STG'] ?></td>
            <td><?= $demande['DATE_POSER'] ?></td>
            <td><?= $demande['ETAT_POSER'] ?></td>
            <td>
            <?php if ($demande['ETAT_POSER'] === 'En attente'): ?>
    <a href="actions/valider_attestation.php?id=<?= $demande['ID_MSG'] ?>&etat=Validée">✅ Valider</a> |
    <a href="actions/valider_attestation.php?id=<?= $demande['ID_MSG'] ?>&etat=Refusée">❌ Refuser</a>
<?php elseif ($demande['ETAT_POSER'] === 'Validée'): ?>
    <a href="attestation_pdf.php?id=<?= $demande['ID_MSG'] ?>" target="_blank">📄 Télécharger PDF</a>
<?php else: ?>
    <i>Refusée</i>
<?php endif; ?>

            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
