<?php
include 'connection.php';

//1.securite admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit;
}
  
$message = '';
  
if (isset($_POST['submit'])) {
    $pseudo = trim($_POST['nom_utilisateur'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $pass = trim($_POST['pass'] ?? '');
    $cpass = trim($_POST['cpass'] ?? '');

    if (empty($pseudo) || empty($prenom) || empty($nom) || empty($email) || empty($pass) || empty($cpass)) {
        $message = "Remplis tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email invalide.";
    } elseif ($pass !== $cpass) {
        $message = "Les mots de passe sont différents.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
        $message = "Mot de passe trop faible.";
    } else {
        $check = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $message = "Email déjà utilisé.";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $role = 'employe';

            $insert = $conn->prepare("INSERT INTO utilisateur (nom, prenom, pseudo, email, mdp, role) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([$nom, $prenom, $pseudo, $email, $hash, $role]);

            $to = $email;
            $subject = "Confirmation de création de compte - Cinéphoria";
            $content = "Bonjour $prenom,\n\nVotre compte Cinéphoria a bien été créé.\n\nVous pouvez maintenant vous connecter.";
            $headers = "From: no-reply@cinephoria.com";

            mail($to, $subject, $content, $headers);

            header('Location: admin.php');
            exit;

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

    <title>CINEPHORIA</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Ajouter un employé</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Création d'un employé</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">

    <div class="mb-3">
        <label class="form-label">Nom d'utilisateur</label>
        <input type="text" name="nom_utilisateur" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Prénom</label>
        <input type="text" name="prenom" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="pass" class="form-control" />
    </div>

    <div class="mb-3">
        <label class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="cpass" class="form-control" />
    </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
        <button type="submit" name="submit" class="btn">
            Créer l'employé
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


