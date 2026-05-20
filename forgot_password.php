<?php
include 'connection.php';

$message = '';

if (isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email invalide.";
    } else {
        $select_user = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() > 0) {
            $user = $select_user->fetch(PDO::FETCH_ASSOC);

            $new_password = bin2hex(random_bytes(4));
            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE utilisateur SET mdp = ? WHERE email = ?");
            $update->execute([$hash, $email]);

            mail($user['email'], "Nouveau mot de passe", "Votre nouveau mot de passe = $new_password");

            $message = "Un nouveau mot de passe a été envoyé.";
        } else {
            $message = "Aucun compte trouvé pour cet email.";
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
            <h1>Mot de passe oublié</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Réinitialiser votre mot de passe</p>


        <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">
    <div class="mb-3">
            <p>Ton email <sup>*</sup></p>
            <input type="email" name="email" class="form-control" required placeholder="Enter your email" maxlength="50" 
            oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
    <input type="submit" name="submit" value="reinitialiser" class="btn">
    </div>
     <p class="text-center"> Vous n'avez encore pas de compte ? <a href="inscription.php">Inscrivez-vous ! </a></p>
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
