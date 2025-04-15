<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'stagiaire.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $stagiaire = new Stagiaire();
    $user = $stagiaire->login($email, $password);

    if ($user) {
        $_SESSION['ID_STG'] = $user['ID_STG'];
        $_SESSION['NOM_STG'] = $user['NOM_STG'];
        $_SESSION['PRN_STG'] = $user['PRN_STG'];

        header('Location: espace_stagiaire.php');
        exit;
    } else {
        echo "❌ Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Stagiaire</title>
</head>
<body>
    <h2>🔐 Connexion Stagiaire</h2>
    <form method="POST" action="">
        <label>Email :</label><br>
        <input type="email" name="login" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
