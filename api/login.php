<?php

include '../connection.php';

header('Content-Type: application/json');

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$pass = trim($_POST['pass'] ?? '');

if (empty($email) || empty($pass)) {
    echo json_encode([
        "success" => false,
        "message" => "Remplis tous les champs"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Email invalide"
    ]);
    exit;
}

$select_user = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
$select_user->execute([$email]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode([
        "success" => false,
        "message" => "Utilisateur non trouvé"
    ]);
    exit;
}

if (password_verify($pass, $row['mdp'])) {
    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $row['id_utilisateur'],
            "nom" => $row['nom'],
            "prenom" => $row['prenom'],
            "pseudo" => $row['pseudo'],
            "email" => $row['email'],
            "role" => $row['role']
        ],
        "message" => "Connexion réussie"
    ]);
    exit;
} else {
    echo json_encode([
        "success" => false,
        "message" => "Mot de passe incorrect"
    ]);
    exit;
}
?>

