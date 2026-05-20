<?php

include '../connection.php';

header('Content-Type: application/json');

$id_utilisateur = $_POST['id_utilisateur'] ?? '';

if (empty($id_utilisateur)) {
    echo json_encode([
        "success" => false,
        "message" => "Utilisateur manquant"
    ]);
    exit;
}

$select_seances = $conn->prepare("SELECT 
        reservation.idreservation,
        reservation.date_reservation,
        reservation.statut,
        reservation.nb_places,
        reservation.siege,

        seance.idseance,
        seance.date_heure,
        seance.version,
        seance.prix,

        film.idfilm,
        film.titre,
        film.duree_min,
        film.image_affiche,

        salle.idsalle,
        salle.Nom AS nom_salle,
        salle.qualite
    FROM reservation
    INNER JOIN seance 
        ON reservation.id_seance = seance.idseance
    INNER JOIN film 
        ON seance.id_film = film.idfilm
    INNER JOIN salle 
        ON seance.id_salle = salle.idsalle
    WHERE reservation.id_client_reservation = ?
    ORDER BY seance.date_heure ASC
");

$select_seances->execute([$id_utilisateur]);
$seances = $select_seances->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "seances" => $seances
]);

?>