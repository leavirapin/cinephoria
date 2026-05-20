<?php

include '../connection.php';

header('Content-Type: application/json');

$id = filter_var($_POST['id_utilisateur'] ?? '', FILTER_SANITIZE_NUMBER_INT);


 if (empty($id)) {
    echo json_encode([
    "success" => false,
    "message" => "Remplis tous les champs"
]);
exit;
}


$select_billets = $conn->prepare("SELECT * FROM reservation INNER JOIN seance ON reservation.id_seance = seance.idseance INNER JOIN film ON seance.id_film = film.idfilm INNER JOIN salle ON reservation.id_salle = salle.idsalle WHERE reservation.id_client_reservation = ?");
$select_billets->execute([$id]);
if ($select_billets->rowCount() > 0) {
    $billets= $select_billets->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($billets)){
    echo json_encode([
    "billets" => $billets,
    "success" => true,
    "message" => "Billet(s) récupéré(s)"
]);
exit;
}else{
    echo json_encode([
    "success" => false,
    "message" => "Aucun billet trouvé"
]);
exit;
}
?>

