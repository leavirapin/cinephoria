<?php
include 'connection.php';
session_start();

// sécurité admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// récupérer id
$id = $_GET['id'];

// récupérer film
$select = $conn->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
$select->execute([$id]);
$employe = $select->fetch(PDO::FETCH_ASSOC);

// creation nouveau mdp
$new_password = bin2hex(random_bytes(4));

// mdp securisé
 $hash = password_hash($new_password, PASSWORD_DEFAULT);

// update
$update = $conn->prepare("UPDATE utilisateur SET mdp = ? WHERE id_utilisateur = ?");
$update->execute([$hash, $id]);

mail($employe['email'], "Nouveau mot de passe", "Votre nouveau mot de passe = $new_password");

header('Location: admin.php');
exit;


