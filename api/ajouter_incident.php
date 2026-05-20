<?php

include '../connection.php';

header('Content-Type: application/json');

$salle = trim($_POST['salle'] ?? '');
$type_incident = trim($_POST['type_incident'] ?? '');
$description = trim($_POST['description'] ?? '');

if (empty($salle) || empty($type_incident) || empty($description)) {
    echo json_encode([
        "success" => false,
        "message" => "Tous les champs sont obligatoires"
    ]);
    exit;
}

$insert_incident-> $conn->prepare("INSERT INTO incident (salle, type_incident, description) VALUES(?,?,?)");

$insert_incident->execute([
    $salle,
    $type_incident,
    $description
]);

    echo json_encode([
        "success" => true,
        "message" => "Incident ajouté avec succès"
    ]);

?>
