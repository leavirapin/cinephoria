<?php
include 'connection.php';

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

if($user_id == ''){
    header('location: login.php');
    exit;
}

if(isset($_POST['logout'])){
   session_destroy();
   header('location: login.php');
   exit;
}

$message = '';

if (isset($_POST['submit'])) {

$idfilm = $_GET['idfilm'] ?? '';
$note = htmlspecialchars(trim($_POST['note']));
$commenataires = htmlspecialchars(trim($_POST['commentaires']));


$insert_avis = $conn->prepare("INSERT INTO avis (note, commentaires, statut, id_client_avis, id_film_avis) VALUES (?,?,?,?,?)");
$insert_avis->execute([$note, $commenataires, 'en_attente', $user_id, $id_film_avis]);
header('Location: mon_espace.php');
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
            <h1>Noter votre film</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Note</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">
    <label class="form-label">Note</label>
    <input type="number" name="note" class="form-control" min="1" max="5" required />
    

<div class="mb-3">
    <label class="form-label">Commentaire</label>
    <textarea name="commentaires" class="form-control" required></textarea>
</div>

<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
  <button type="submit" name="submit" class="btn">Envoyer votre avis</button>
</div>

        </form>
    </div>
  </div>
</section>

        <?php include 'footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'alert.php'; ?>
</body>
</html>
