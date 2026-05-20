<?php
include 'connection.php';

$message = '';
if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($titre) || empty($description)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        $insert_contact = $conn->prepare("INSERT INTO contact (nom, titre, description) VALUES (?,?,?)");
        $insert_contact->execute([$nom, $titre, $description]);

            $to = "contact@cinephoria.com";
            $subject = $titre;
            $content = "Nom : $nom\n\nMessage : $description";
            $headers = "From: no-reply@cinephoria.com";

            mail($to, $subject, $content, $headers);

        $message = "Votre message a bien été recu";

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

    <title>CINEPHORIA</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Contactez-nous</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Laissez nous un message !</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">
    <label class="form-label">Nom </label>
    <input type="text" name="nom" class="form-control" />
    

        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" />
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" />
        </div>

        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
        <button type="submit" name="submit" class="btn">Envoyez votre message</button>
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




