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

// récupérer id
$id = (int) ($_GET['idsalle'] ?? 0);

// récupérer film
$select = $conn->prepare("SELECT * FROM salle WHERE idsalle = ?");
$select->execute([$id]);
$salle = $select->fetch(PDO::FETCH_ASSOC);

// update
if (isset($_POST['submit'])) {


$Nom =trim($_POST['Nom']);
$Nombre_de_siege = (int) ($_POST['Nombre_de_siege']);
$qualite = trim($_POST['qualite']);
$id_cinema =(int) ($_POST['id_cinema']);

$update = $conn->prepare("UPDATE salle SET Nom = ?, Nombre_de_siege = ?, qualite = ?, id_cinema = ? WHERE idsalle = ?");
$update->execute([$Nom, $Nombre_de_siege, $qualite, $id_cinema, $id]);

    if ($_SESSION['user_role'] == 'employe') {
      header('Location: intranet.php');
    }else{
      header('Location:admin.php');
    }
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
            <h1>Modifier une salle</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Modifie la salle de ton choix</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form method="post" class="mx-1 mx-md-4">

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="Nom" class="form-control"
        value="<?= htmlspecialchars($salle['Nom']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Nombre de sièges</label>
        <input type="number" name="Nombre_de_siege" class="form-control"
        value="<?= htmlspecialchars($salle['Nombre_de_siege']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Qualité</label>
        <input type="text" name="qualite" class="form-control"
        value="<?= htmlspecialchars($salle['qualite']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">ID cinéma</label>
        <input type="text" name="id_cinema" class="form-control"
        value="<?= htmlspecialchars($salle['id_cinema']) ?>">
    </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
        <button type="submit" name="submit" class="btn">
            Modifier
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



