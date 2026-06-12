<?php

$host = "acela.proxy.rlwy.net";
$port = "28901";
$dbname = "railway";
$user = "root";
$password = "TON_MOT_DE_PASSE_RAILWAY";

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    die("Erreur : " . $e->getMessage());
}

?>



















































































