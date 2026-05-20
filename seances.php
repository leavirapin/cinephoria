<?php
include 'connection.php';

$idfilm = $_GET['idfilm'] ?? '';

$select_seance = $conn->prepare("
    SELECT * FROM seance 
    WHERE id_film = ?
");

$select_seance->execute([$idfilm]);

$seances = $select_seance->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéphoria - Séances</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>

<body class="bg-light">

<?php include 'header.php'; ?>

<div class="main">

    <div class="banner">
        <h1>Séances</h1>
    </div>

    <div class="container py-5">

        <div class="row g-4">

            <?php if (count($seances) > 0): ?>

                <?php foreach ($seances as $seance): ?>

                    <div class="col-12 col-md-6 col-lg-4">

                        <div class="card h-100 shadow-sm p-3">

                            <h2 class="card-title h5 mb-3">
                                Séance disponible
                            </h2>

                            <p class="mb-2">
                                <strong>Date :</strong>
                                <?= htmlspecialchars($seance['date_heure']); ?>
                            </p>

                            <p class="mb-2">
                                <strong>Version :</strong>
                                <?= htmlspecialchars($seance['version']); ?>
                            </p>

                            <p class="mb-2">
                                <strong>Prix :</strong>
                                <?= htmlspecialchars($seance['prix']); ?> €
                            </p>

                            <p class="mb-3">
                                <strong>Salle :</strong>
                                <?= htmlspecialchars($seance['id_salle']); ?>
                            </p>

                            <a href="reservation.php?idseance=<?= (int)$seance['idseance']; ?>" class="btn"> Réserver </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p class="text-center">
                    Aucune séance disponible pour ce film.
                </p>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'alert.php'; ?>

</body>
</html>

