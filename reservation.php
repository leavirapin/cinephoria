<?php
include 'connection.php';

$user_id = $_SESSION['user_id'] ?? null;
$message = "";


/* 1. Récupération l'id de la séance  */
$idseance = (int)($_GET['idseance'] ?? 0);

if ($idseance <= 0) {
    die("Aucune séance trouvée. Vérifie que l'URL contient bien ?idseance=...");
}

/* 2. Récupéreration la séance */
$sql = "SELECT * FROM seance WHERE idseance = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$idseance]);
$seance = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seance) {
    die("Aucune séance trouvée.");
}

/* 3. Récupéreration des sièges déjà réservés */
$select_sieges = $conn->prepare("SELECT siege FROM reservation WHERE id_seance = ?");
$select_sieges->execute([$idseance]);
$sieges_reserves = $select_sieges->fetchAll(PDO::FETCH_COLUMN);

/* 4. Récupéreration du nombre de places déjà réservées */
$select_places = $conn->prepare("
    SELECT SUM(nb_places) AS places_reservees
    FROM reservation
    WHERE id_seance = ?
");
$select_places->execute([$idseance]);
$result_places = $select_places->fetch(PDO::FETCH_ASSOC);

$places_reservees = $result_places['places_reservees'] ?? 0;

/* 5. Récupéreration de la capacité de la salle */
$select_salle = $conn->prepare("
    SELECT Nombre_de_siege
    FROM salle
    WHERE idsalle = ?
");
$select_salle->execute([$seance['id_salle']]);
$result_salle = $select_salle->fetch(PDO::FETCH_ASSOC);

$capacite_salle = $result_salle['Nombre_de_siege'] ?? 0;

/* 6. Calcul des places restantes */
$places_restantes = $capacite_salle - $places_reservees;

/* 7. Traitement du formulaire */
if (isset($_POST['submit'])) {

    $place = (int)($_POST['place'] ?? 0);
    $siege = trim($_POST['siege'] ?? '');
    $pmr = trim($_POST['pmr'] ?? 0);

    if (!$user_id) {
        die('Vous devez vous connecter pour réserver.');
    } elseif ($place <= 0) {
        $message = "Veuillez choisir un nombre de places valide.";
    } elseif (empty($siege)) {
        $message = "Veuillez choisir un siège.";
    } elseif ($place > $places_restantes) {
        $message = "Il ne reste que " . $places_restantes . " place(s) disponible(s).";
    } else {

        $check = $conn->prepare("
            SELECT * FROM reservation
            WHERE id_seance = ? AND siege = ?
        ");
        $check->execute([$idseance, $siege]);

        if ($check->rowCount() > 0) {
            $message = "Ce siège est déjà réservé.";
        } else {

            $date_reservation = date("Y-m-d H:i:s");
            $statut = "Payer";

            $insert_reservation = $conn->prepare("
                INSERT INTO reservation
                (date_reservation, statut, nb_places, id_seance, siege, id_client_reservation, pmr)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $insert_reservation->execute([
                $date_reservation,
                $statut,
                $place,
                $idseance,
                $siege,
                $user_id,
                $pmr
            ]);

            $message = "Réservation enregistrée avec succès.";
           
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <link rel="stylesheet" href="style.css">

   <title>CINÉPHORIA</title>
</head>

<body>

<?php include 'header.php'; ?>

<div class="container my-5">
   <div class="card mb-4 shadow">
      <div class="card-body text-center">
         <h4 class="card-title mb-4">
            Récapitulatif de la séance
         </h4>

         <p>
            <strong>Date :</strong>
            <?= htmlspecialchars($seance['date_heure']); ?>
         </p>

         <p>
            <strong>Version :</strong>
            <?= htmlspecialchars($seance['version']); ?>
         </p>

         <p>
            <strong>Salle :</strong>
            <?= htmlspecialchars($seance['id_salle']); ?>
         </p>

         <p>
            <strong>Prix :</strong>
            <?= htmlspecialchars($seance['prix']); ?> €
         </p>

         <p>
            <strong>Places restantes :</strong>
            <?= htmlspecialchars($places_restantes); ?>
         </p>

      </div>
   </div>


   <?php if(!empty($message)){ ?>
      <div class="alert alert-info text-center" role="alert">
         <?= htmlspecialchars($message); ?>
      </div>
   <?php } ?>


   <form action="" method="post">
      <div class="card shadow">
         <div class="card-body text-center">
            <h3 class="card-title mb-4">
               Choisissez votre siège
            </h3>

            <input type="hidden" name="idseance" value="<?= (int)$idseance; ?>">
            <input type="hidden" name="siege" id="siege">
            <input type="hidden" name="par" id="par" value="0">

            <div class="bg-dark text-white py-2 rounded mb-5">
               ÉCRAN
            </div>

            <!-- Rangée A -->
            <div class="row justify-content-center g-2 mb-3">

               <?php foreach(['A1','A2','A3'] as $siegeNom){ ?>

                  <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                     <?php if(in_array($siegeNom, $sieges_reserves)){ ?>

                        <button type="button"
                           class="btn btn-danger w-100"
                           disabled>

                           <?= $siegeNom; ?>

                        </button>

                     <?php } else { ?>

                        <button type="button"
                           class="btn btn-outline-primary w-100"

                           onclick="
                              document.getElementById('siege').value='<?= $siegeNom; ?>';
                              document.getElementById('par').value='0';
                           ">

                           <?= $siegeNom; ?>

                        </button>

                     <?php } ?>

                  </div>

               <?php } ?>

            </div>

            <!-- Rangée B -->
            <div class="row justify-content-center g-2 mb-3">

               <?php foreach(['B1','B2','B3'] as $siegeNom){ ?>

                  <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                     <?php if(in_array($siegeNom, $sieges_reserves)){ ?>

                        <button type="button"
                           class="btn btn-danger w-100"
                           disabled>

                           <?= $siegeNom; ?>

                        </button>

                     <?php } else { ?>

                        <button type="button"
                           class="btn btn-outline-primary w-100"

                           onclick="
                              document.getElementById('siege').value='<?= $siegeNom; ?>';
                              document.getElementById('par').value='0';
                           ">

                           <?= $siegeNom; ?>

                        </button>

                     <?php } ?>

                  </div>

               <?php } ?>

            </div>

            <!-- Rangée C -->
            <div class="row justify-content-center g-2 mb-4">

               <?php foreach(['C1','C2','C3'] as $siegeNom){ ?>

                  <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                     <?php if(in_array($siegeNom, $sieges_reserves)){ ?>

                        <button type="button"
                           class="btn btn-danger w-100"
                           disabled>

                           <?= $siegeNom; ?>

                        </button>

                     <?php } else { ?>

                        <button type="button"
                           class="btn btn-outline-primary w-100"

                           onclick="
                              document.getElementById('siege').value='<?= $siegeNom; ?>';
                              document.getElementById('par').value='0';
                           ">

                           <?= $siegeNom; ?>

                        </button>

                     <?php } ?>

                  </div>

               <?php } ?>

            </div>


            <div class="mb-4">
               <label for="place" class="form-label">
                  Nombre de places
               </label>
               <input type="number"
                  name="place"
                  id="place"
                  class="form-control"

                  min="1"
                  max="<?= (int)$places_restantes; ?>"required>
            </div>


            <input type="submit" name="submit"value="Valider" class="btn btn-primary w-100">


            <p class="mt-4">
               Vous n’avez pas de compte ?
               <a href="register.php">Inscrivez-vous</a>
            </p>
         </div>
      </div>
   </form>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include 'alert.php'; ?>
</body>
</html>

