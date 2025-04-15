<?php
require_once 'connection.php';

$db = new Database();
$conn = $db->connect();

// Récupération des utilisateurs
$stagiaires = $conn->query("SELECT * FROM stagiaire")->fetchAll(PDO::FETCH_ASSOC);
$encadrants = $conn->query("SELECT * FROM encadrant")->fetchAll(PDO::FETCH_ASSOC);
$liste_encadrants = $conn->query("SELECT ID_ENC, NOM_ENC, PRN_ENC FROM encadrant")->fetchAll(PDO::FETCH_ASSOC);
$liste_niveaux = $conn->query("SELECT ID_NIV, NUM_NIV FROM niveau")->fetchAll(PDO::FETCH_ASSOC);
$liste_groupes = $conn->query("SELECT ID_GRP, NUM_GRP FROM groupe")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body class="p-4 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">Gestion des utilisateurs</h1>
    




    <?php if (isset($_GET['message'])): ?>
    <div style="background-color: #d1fae5; padding: 10px; color: #065f46; margin-bottom: 20px; border-radius: 5px;">
        <?php
            switch ($_GET['message']) {
                case 'email_existe':
                    echo "⚠️ Cet email est déjà utilisé. Veuillez en choisir un autre.";
                    break;
                case 'ajout':
                    echo "✅ Utilisateur ajouté avec succès.";
                    break;
                case 'modification':
                    echo "✏️ Utilisateur modifié avec succès.";
                    break;
                case 'suppression':
                    echo "🗑️ Utilisateur supprimé avec succès.";
                    break;
            }
        ?>
    </div>
<?php endif; ?>



    <!-- 🔍 Recherche -->
    <form method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Rechercher..." class="border p-2 rounded">
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Rechercher</button>
    </form>

    <!-- 👤 Ajouter un utilisateur -->
    <h2 class="text-xl font-semibold mb-2">Ajouter un utilisateur</h2>
    <form method="POST" action="actions/ajouter_utilisateur.php" class="space-y-2 mb-6">
        <input type="text" name="nom" placeholder="Nom" required class="border p-2 rounded w-full">
        <input type="text" name="prenom" placeholder="Prénom" required class="border p-2 rounded w-full">
        <input type="email" name="email" placeholder="Email" required class="border p-2 rounded w-full">
        <input type="password" name="mdp" placeholder="Mot de passe" required class="border p-2 rounded w-full">
        
        <!-- Rôle -->
        <select name="role" id="role" required class="border p-2 rounded w-full" onchange="toggleFields(this.value)">
            <option value="">-- Sélectionner un rôle --</option>
            <option value="stagiaire">Stagiaire</option>
            <option value="encadrant">Encadrant</option>
        </select>

        <!-- Champs spécifiques pour stagiaire -->
        <div id="extra-fields" style="display:none;">
            <select name="id_enc" class="border p-2 rounded w-full">
                <option value="">-- Sélectionner un encadrant --</option>
                <?php foreach ($liste_encadrants as $enc): ?>
                    <option value="<?= $enc['ID_ENC'] ?>">
                        <?= $enc['NOM_ENC'] . ' ' . $enc['PRN_ENC'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="id_niv" class="border p-2 rounded w-full">
                <option value="">-- Sélectionner un niveau --</option>
                <?php foreach ($liste_niveaux as $niv): ?>
                    <option value="<?= $niv['ID_NIV'] ?>"><?= $niv['NUM_NIV'] ?></option>
                <?php endforeach; ?>
            </select>
            <select name="id_grp" class="border p-2 rounded w-full">
    <option value="">-- Sélectionner un groupe --</option>
    <?php foreach ($liste_groupes as $grp): ?>
        <option value="<?= $grp['ID_GRP'] ?>"><?= $grp['NUM_GRP'] ?></option>
    <?php endforeach; ?>
</select>

        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Ajouter</button>
    </form>

    <script>
    function toggleFields(role) {
        document.getElementById('extra-fields').style.display = (role === 'stagiaire') ? 'block' : 'none';
    }
    </script>

    <!-- 📋 Liste des stagiaires -->
    <h2 class="text-xl font-semibold">Liste des stagiaires</h2>
    <table class="w-full bg-white mb-8 border">
        <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($stagiaires as $stg): ?>
            <tr class="border-b">
                <td><?= htmlspecialchars($stg['NOM_STG']) ?></td>
                <td><?= htmlspecialchars($stg['PRN_STG']) ?></td>
                <td><?= htmlspecialchars($stg['MAIL_STG']) ?></td>
                <td>
                    <a href="actions/modifier_utilisateur.php?id=<?= $stg['ID_STG'] ?>&role=stagiaire" class="text-blue-500">Modifier</a> |
                    <a href="actions/supprimer_utilisateur.php?id=<?= $stg['ID_STG'] ?>&role=stagiaire" class="text-red-500" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- 👨‍🏫 Liste des encadrants -->
    <h2 class="text-xl font-semibold">Liste des encadrants</h2>
    <table class="w-full bg-white border">
        <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($encadrants as $enc): ?>
            <tr class="border-b">
                <td><?= htmlspecialchars($enc['NOM_ENC']) ?></td>
                <td><?= htmlspecialchars($enc['PRN_ENC']) ?></td>
                <td><?= htmlspecialchars($enc['MAIL_ENC']) ?></td>
                <td>
                    <a href="actions/modifier_utilisateur.php?id=<?= $enc['ID_ENC'] ?>&role=encadrant" class="text-blue-500">Modifier</a> |
                    <a href="actions/supprimer_utilisateur.php?id=<?= $enc['ID_ENC'] ?>&role=encadrant" class="text-red-500" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
