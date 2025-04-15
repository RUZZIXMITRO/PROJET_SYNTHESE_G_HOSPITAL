<?php
require_once 'connection.php';

class Stagiaire {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Vérification du login
    public function login($email, $password) {
        $query = "SELECT * FROM stagiaire WHERE MAIL_STG = :email AND MDP_STG = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
                session_start();
                $_SESSION['nom'] = $user['NOM_STG'];
                $_SESSION['prenom'] = $user['PRENOM_STG'];


            }
        }

        return false;
    }

    // Récupération de la liste des stagiaires
    public function getUsers() {
        $query = "SELECT * FROM stagiaire";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
