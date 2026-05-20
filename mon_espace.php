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

$user_name = $_SESSION['user_name'] ??'';
$user_email = $_SESSION['user_email'] ??'';

$select_commandes = $conn->prepare("SELECT reservation.*, seance.date_heure,seance.version,seance.prix,film.titre,film.idfilm FROM reservation INNER JOIN seance ON reservation.id_seance = seance.idseance INNER JOIN film ON seance.id_film = film.idfilm WHERE reservation.id_client_reservation = ? ORDER BY  reservation.date_reservation DESC
");

$select_commandes->execute([$user_id]);
$commandes = $select_commandes->fetchAll(PDO::FETCH_ASSOC);

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
            <h1>Votre espace</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Bienvenue dans votre espace</p>

        <p><strong>Nom :</strong> <?= htmlspecialchars($user_name); ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user_email); ?></p>

        <h2>Mes commandes</h2>

<?php if (count($commandes) > 0): ?>

   <?php foreach ($commandes as $commande): ?>

      <div class="box mb-3">

         <p>
            <strong>Film :</strong>
            <?= htmlspecialchars($commande['titre']); ?>
         </p>

         <p>
            <strong>Date réservation :</strong>
            <?= htmlspecialchars($commande['date_reservation']); ?>
         </p>

         <p>
            <strong>Date séance :</strong>
            <?= htmlspecialchars($commande['date_heure']); ?>
         </p>

         <p>
            <strong>Nombre de places :</strong>
            <?= htmlspecialchars($commande['nb_places']); ?>
         </p>

         <p>
            <strong>Statut :</strong>
            <?= htmlspecialchars($commande['statut']); ?>
         </p>

         <?php if (strtotime($commande['date_heure']) < time()): ?>
            <a href="noter.php?idfilm=<?= (int)$commande['idfilm']; ?>" class="btn">
               Noter le film
            </a>
         <?php endif; ?>

      </div>

   <?php endforeach; ?>

<?php else: ?>

   <p>Aucune commande pour le moment.</p>

<?php endif; ?>
              

<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
  <button type="submit" name="submit" class="btn">Se déconnecter</button>
</div>

        </form>
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




