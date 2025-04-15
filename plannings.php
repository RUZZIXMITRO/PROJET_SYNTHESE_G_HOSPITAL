<?php
require_once 'connection.php';
$db = new Database();
$conn = $db->connect();

// Récupérer données pour les listes déroulantes
$stagiaires = $conn->query("SELECT ID_STG, NOM_STG, PRN_STG FROM stagiaire")->fetchAll(PDO::FETCH_ASSOC);
$services = $conn->query("SELECT ID_SER, NOM_SER FROM service")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les affectations existantes
$plannings = $conn->query("
    SELECT s.NOM_STG, s.PRN_STG, sv.NOM_SER, p.DATE_DEB_STG, p.DATE_FIN_STG, p.ID_PLANNING
    FROM planning p
    JOIN stagiaire s ON s.ID_STG = p.ID_STG
    JOIN service sv ON sv.ID_SER = p.ID_SER
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des plannings</title>
</head>
<body>
    <h1>🗓️ Gestion des plannings</h1>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'ajout'): ?>
    <div style="background-color: #d1fae5; padding: 10px; color: #065f46; margin-bottom: 20px; border-radius: 5px;">
        ✅ Affectation ajoutée avec succès !
    </div>
<?php endif; ?>
    <!-- Formulaire ajout -->
    <h2>➕ Ajouter une affectation</h2>
    <form method="POST" action="actions/ajouter_planning.php">
        <select name="id_stg" required>
            <option value="">-- Stagiaire --</option>
            <?php foreach ($stagiaires as $stg): ?>
                <option value="<?= $stg['ID_STG'] ?>"><?= $stg['NOM_STG'] . ' ' . $stg['PRN_STG'] ?></option>
            <?php endforeach; ?>
        </select>

        <select name="id_ser" required>
            <option value="">-- Service hospitalier --</option>
            <?php foreach ($services as $ser): ?>
                <option value="<?= $ser['ID_SER'] ?>"><?= $ser['NOM_SER'] ?></option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="date_deb" required>
        <input type="date" name="date_fin" required>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Tableau des plannings -->
    <h2>📋 Affectations existantes</h2>
    <table border="1">
        <tr>
            <th>Stagiaire</th>
            <th>Service</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Action</th>
        </tr>
        <?php foreach ($plannings as $p): ?>
            <tr>
                <td><?= $p['NOM_STG'] . ' ' . $p['PRN_STG'] ?></td>
                <td><?= $p['NOM_SER'] ?></td>
                <td><?= $p['DATE_DEB_STG'] ?></td>
                <td><?= $p['DATE_FIN_STG'] ?></td>
                <td><a href="actions/supprimer_planning.php?id=<?= $p['ID_PLANNING'] ?>" onclick="return confirm('Supprimer ?')">❌</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
