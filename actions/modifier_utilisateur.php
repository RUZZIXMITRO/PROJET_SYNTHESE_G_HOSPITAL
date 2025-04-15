<?php
require_once '../connection.php';

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;
$role = $_GET['role'] ?? null;

if (!$id || !$role) {
    die("Paramètres manquants.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement de la mise à jour
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp_hash = !empty($mdp) ? password_hash($mdp, PASSWORD_DEFAULT) : null;

    if ($role === 'stagiaire') {
        $id_enc = $_POST['id_enc'];
        $id_niv = $_POST['id_niv'];
        $id_grp = $_POST['id_grp'];

        $sql = "UPDATE stagiaire SET NOM_STG=?, PRN_STG=?, MAIL_STG=?, ID_ENC=?, ID_NIV=?, ID_GRP=?" .
               ($mdp_hash ? ", MDP_STG=?" : "") . " WHERE ID_STG=?";
        $params = [$nom, $prenom, $email, $id_enc, $id_niv, $id_grp];
        if ($mdp_hash) $params[] = $mdp_hash;
        $params[] = $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

    } elseif ($role === 'encadrant') {
        $sql = "UPDATE encadrant SET NOM_ENC=?, PRN_ENC=?, MAIL_ENC=?" .
               ($mdp_hash ? ", MDP_ENC=?" : "") . " WHERE ID_ENC=?";
        $params = [$nom, $prenom, $email];
        if ($mdp_hash) $params[] = $mdp_hash;
        $params[] = $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }

    header("Location: ../admin.php?message=modification");

    exit;
}

// --- Récupération des données existantes ---
if ($role === 'stagiaire') {
    $stmt = $conn->prepare("SELECT * FROM stagiaire WHERE ID_STG = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $encadrants = $conn->query("SELECT * FROM encadrant")->fetchAll(PDO::FETCH_ASSOC);
    $niveaux = $conn->query("SELECT * FROM niveau")->fetchAll(PDO::FETCH_ASSOC);
    $groupes = $conn->query("SELECT * FROM groupe")->fetchAll(PDO::FETCH_ASSOC);

} elseif ($role === 'encadrant') {
    $stmt = $conn->prepare("SELECT * FROM encadrant WHERE ID_ENC = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$user) {
    die("Utilisateur introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier <?= $role ?></title>
</head>
<body>
    <h1>Modifier <?= ucfirst($role) ?></h1>

    <form method="POST">
        <input type="text" name="nom" value="<?= $user[$role === 'stagiaire' ? 'NOM_STG' : 'NOM_ENC'] ?>" required><br>
        <input type="text" name="prenom" value="<?= $user[$role === 'stagiaire' ? 'PRN_STG' : 'PRN_ENC'] ?>" required><br>
        <input type="email" name="email" value="<?= $user[$role === 'stagiaire' ? 'MAIL_STG' : 'MAIL_ENC'] ?>" required><br>
        <input type="password" name="mdp" placeholder="Laisser vide pour ne pas modifier"><br>

        <?php if ($role === 'stagiaire'): ?>
            <select name="id_enc">
                <option value="">-- Encadrant --</option>
                <?php foreach ($encadrants as $e): ?>
                    <option value="<?= $e['ID_ENC'] ?>" <?= $e['ID_ENC'] == $user['ID_ENC'] ? 'selected' : '' ?>>
                        <?= $e['NOM_ENC'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <select name="id_niv">
                <option value="">-- Niveau --</option>
                <?php foreach ($niveaux as $n): ?>
                    <option value="<?= $n['ID_NIV'] ?>" <?= $n['ID_NIV'] == $user['ID_NIV'] ? 'selected' : '' ?>>
                        <?= $n['NUM_NIV'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <select name="id_grp">
                <option value="">-- Groupe --</option>
                <?php foreach ($groupes as $g): ?>
                    <option value="<?= $g['ID_GRP'] ?>" <?= $g['ID_GRP'] == $user['ID_GRP'] ? 'selected' : '' ?>>
                        <?= $g['NUM_GRP'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
        <?php endif; ?>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
