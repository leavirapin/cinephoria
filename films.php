<?php
include 'connection.php';

$cinema = $_GET['cinema'] ?? '';
$genre = $_GET['genre'] ?? '';
$jour = $_GET['jour'] ?? '';

if (!empty($jour)) {

    $select_films = $conn->prepare("
        SELECT DISTINCT film.*
        FROM film
        INNER JOIN seance ON film.idfilm = seance.id_film
        WHERE DATE(seance.date_heure) = ?
        ORDER BY film.date_ajout DESC
    ");
    $select_films->execute([$jour]);

} elseif (!empty($genre) && !empty($cinema)) {

    $select_films = $conn->prepare("SELECT * FROM film WHERE genre = ? AND idCinema = ? ORDER BY date_ajout DESC");
    $select_films->execute([$genre, $cinema]);

} elseif (!empty($genre)) {

    $select_films = $conn->prepare("SELECT * FROM film WHERE genre = ? ORDER BY date_ajout DESC");
    $select_films->execute([$genre]);

} elseif (!empty($cinema)) {

    $select_films = $conn->prepare("SELECT * FROM film WHERE idCinema = ? ORDER BY date_ajout DESC");
    $select_films->execute([$cinema]);

} else {

    $select_films = $conn->prepare("SELECT * FROM film ORDER BY date_ajout DESC");
    $select_films->execute();
}

$films = $select_films->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <title>CINEPHORIA</title>
</head>

<body>

<?php include 'header.php'; ?>

<main class="main">
    <div class="banner">
        <h1>Films</h1>
    </div>
 
<form method="GET" class="filters-box p-4 mb-5">
  <div class="row g-3">

    <!-- Filtre cinéma -->
    <div class="col-12 col-md-4">
      <label for="cinema" class="form-label">Cinéma</label>
      <select name="cinema" id="cinema" class="form-select">
        <option value="">Tous les cinémas</option>
        <option value="3">Nantes</option>
        <option value="4">Bordeaux</option>
        <option value="5">Paris</option>
        <option value="6">Toulouse</option>
        <option value="7">Lille</option>
        <option value="8">Charleroi</option>
        <option value="9">Liège</option>
      </select>
    </div>

    <!-- Filtre genre -->
    <div class="col-12 col-md-4">
      <label for="genre" class="form-label">Genre</label>
      <select name="genre" id="genre" class="form-select">
        <option value="">Tous les genres</option>
        <option value="Action">Action</option>
        <option value="Science-fiction">Science-fiction</option>
        <option value="Animation">Animation</option>
        <option value="Horreur">Horreur</option>
        <option value="Drame">Drame</option>
      </select>
    </div>

    <!-- Filtre jour -->
    <div class="col-12 col-md-4">
      <label for="jour" class="form-label">Jour</label>
      <input type="date" name="jour" id="jour" class="form-control">
    </div>

    <div class="col-12">
    <button type="submit" class="btn">
        Filtrer
    </button>
</div>


  </div>
</form>

        <div class="row g-4">
            <?php if (count($films) > 0): ?>
                <?php foreach ($films as $film): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm">

                            <img 
                                src="images/<?= !empty($film['image_affiche']) ? htmlspecialchars($film['image_affiche']) : 'photo10.jpg'; ?>" 
                                class="card-img-top" 
                                alt="<?= htmlspecialchars($film['titre']); ?>"
                            >

                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title h5"><?= htmlspecialchars($film['titre']); ?></h2>

                                <p class="card-text">
                                    <?= htmlspecialchars($film['resume']); ?>
                                </p>

                                <p class="mb-1">
                                    <strong>Durée :</strong> <?= htmlspecialchars($film['duree_min']); ?> min
                                </p>

                                <p class="mb-1">
                                    <strong>Âge conseillé :</strong> <?= htmlspecialchars($film['age_conseille']); ?> ans
                                </p>

                                <p class="mb-1">
                                    <strong>Genre :</strong> <?= htmlspecialchars($film['genre']); ?>
                                </p>

                                <p class="mb-2">
                                    <strong>Note :</strong> <?= htmlspecialchars($film['note']); ?>
                                </p>

                                <?php if (!empty($film['coup_de_coeur']) && $film['coup_de_coeur'] != '0'): ?>
                                    <span class="badge text-bg-warning mb-3">Coup de cœur</span>
                                <?php endif; ?>

                                <a href="seances.php?idfilm=<?= (int) $film['idfilm']; ?>" class="btn">
                                    Voir les séances
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun film disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </main>

<?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>

