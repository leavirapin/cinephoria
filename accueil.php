<?php
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

$timestamp = strtotime('last Wednesday');
$dernierMercredi = date('Y-m-d', $timestamp);

$sql = "SELECT * FROM film WHERE date_ajout = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$dernierMercredi]);
$films = $stmt->fetchAll();
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

 <!--slide -->
    <div class="main">
        <section class="banner">
         <div class="banner-content">
                    <h1>Bienvenue chez Cinephoria </h1>
                    <p>Découvrez les films à l'affiche et réservez vos séances directement en ligne. </p>
                    <a href="films.php" class="btn">Voir les films</a>
         </div>
</section>

  <!--section image mercredi  -->
        <section class="films">
            <div class="title">
                <h1>FILMS À LA UNE</h1>
            </div>
            <div class="box-container">
                <?php if (!empty($films)) { ?>
                    <?php foreach ($films as $film) { ?>
                        <div class="box">
                            <img src="images/<?php echo htmlspecialchars($film['image_affiche']); ?>" alt="<?= htmlspecialchars($film['titre']); ?>">
                            <a href="films.php?idfilm=<?php echo (int) $film['idfilm']; ?>" class="btn">Voir les derniers films</a>
                        </div>
                    <?php } ?>
                    <?php } else { ?>
                         <p>Aucun film ajouté le dernier mercredi.</p>
                <?php } ?>
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




        