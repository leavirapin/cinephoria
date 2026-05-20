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

$titre = trim($_POST['titre']);
$resume = trim($_POST['resume']);
$duree_min = (int)trim($_POST['duree_min']);
$genre = trim($_POST['genre']);

$insert_film = $conn->prepare("INSERT INTO film (titre, resume, duree_min, genre) VALUES (?,?,?,?)");
$insert_film->execute([$titre, $resume, $duree_min, $genre]);
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
            <h1>Ajouter un film</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Ajouter un nouveau film</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

 <form class="mx-1 mx-md-4" method="post">

    <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Résumé</label>
        <input type="text" name="resume" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Durée</label>
        <input type="number" name="duree_min" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Genre</label>
        <input type="text" name="genre" class="form-control" />
    </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
        <button type="submit" name="submit" class="btn">
            Ajouter un film
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



