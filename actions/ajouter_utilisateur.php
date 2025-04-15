<?php
require_once '../connection.php';

$db = new Database();
$conn = $db->connect();

// Données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mdp = $_POST['mdp'];
$role = $_POST['role'];

// Validation
if (empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($role)) {
    die("Tous les champs sont requis.");
}

$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

try {
    // Vérifier si l'email existe déjà
    if ($role === 'stagiaire') {
        $check = $conn->prepare("SELECT * FROM stagiaire WHERE MAIL_STG = ?");
    } elseif ($role === 'encadrant') {
        $check = $conn->prepare("SELECT * FROM encadrant WHERE MAIL_ENC = ?");
    }

    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        header("Location: ../admin.php?message=email_existe");
        exit;
    }

    // Ajout après vérification
    if ($role === 'stagiaire') {
        $id_enc = $_POST['id_enc'] ?? null;
        $id_niv = $_POST['id_niv'] ?? null;
        $id_grp = $_POST['id_grp'] ?? null;

        if (empty($id_enc) || empty($id_niv)) {
            die("Encadrant et niveau obligatoires pour un stagiaire.");
        }

        $sql = "INSERT INTO stagiaire (NOM_STG, PRN_STG, MAIL_STG, MDP_STG, ID_ENC, ID_NIV, ID_GRP)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $mdp_hash, $id_enc, $id_niv, $id_grp]);

    } elseif ($role === 'encadrant') {
        $sql = "INSERT INTO encadrant (NOM_ENC, PRN_ENC, MAIL_ENC, MDP_ENC)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $mdp_hash]);
    }

    header("Location: ../admin.php?message=ajout");
    exit;

} catch (PDOException $e) {
    die("Erreur lors de l'ajout : " . $e->getMessage());
}


