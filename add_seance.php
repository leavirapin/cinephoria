<?php
include 'connection.php';

// sécurité admin et employe
if (
    !isset($_SESSION['user_id']) ||
    !in_array($_SESSION['user_role'], ['admin', 'employe'])
) {
    header('Location: login.php');
    exit;
}
  
$message = '';

if (isset($_POST['submit'])) {


$date_heure = trim($_POST['date_heure'] ?? '');
$version = trim($_POST['version'] ?? '');
$prix = (float) ($_POST['prix'] ?? 0);
$id_salle = (int) ($_POST['id_salle'] ?? 0);
$id_film = (int) ($_POST['id_film'] ?? 0);

$insert_seance = $conn->prepare("INSERT INTO seance (date_heure, version, prix, id_salle, id_film) VALUES (?,?,?,?,?)");
$insert_seance->execute([$date_heure, $version, $prix, $id_salle, $id_film]);
header('Location: admin.php');
exit;
}
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

    <div class="main">
        <div class="banner">
            <h1>Ajouter une séance</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Ajouter une nouvelle séance</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">

    <div class="mb-3">
        <label class="form-label">Date et heure</label>
        <input type="datetime-local" name="date_heure" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Version</label>
        <input type="text" name="version" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Prix</label>
        <input type="number" name="prix" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">ID Salle</label>
        <input type="number" name="id_salle" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">ID Film</label>
        <input type="number" name="id_film" class="form-control" />
    </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
        <button type="submit" name="submit" class="btn">
            Ajouter une séance
        </button>
    </div>

              </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <?php include 'footer.php'; ?>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
