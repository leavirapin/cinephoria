<?php
include 'connection.php';



if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

$message = '';
//register user

if (isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pass = trim($_POST['pass'] ??'');
 

    $select_user = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $select_user->execute([$email]);

if ($select_user->rowCount() > 0) {
    $row= $select_user->fetch(PDO::FETCH_ASSOC);


    if (password_verify($pass, $row['mdp'])) {
        $_SESSION['user_id'] = $row['id_utilisateur'];
        $_SESSION['user_name'] = $row['nom'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_role'] = $row['role'];


        header('location: accueil.php');
        exit;
    }else{
        $message = 'Mot de passe incorrect';
    }
}else{
    $message = 'utilisateur non trouvé';
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
            <h1>Connectez-vous</h1>
        </div>

<section class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Connexion</p>

                <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

<form class="mx-1 mx-md-4" method="post">
    <div class="mb-3">
            <p>Ton email <sup>*</sup></p>
            <input type="email" name="email" class="form-control" required placeholder="Enter your email" maxlength="50" 
            oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

    <div class="mb-3">
        <p>Ton mot de passe <sup>*</sup></p>
        <input type="password" name="pass" class="form-control" required placeholder="Enter your password" maxlength="50"
        oninput="this.value = this.value.replace(/\s/g, '')">
    </div>

    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
    <input type="submit" name="submit" value="Se connecter" class="btn">
    </div>
    <p class="text-center"> Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous ! </a></p>
    <p class="text-center"> Mot de passe oublié ? <a href="forgot_password.php">Cliquez-ici pour le récupérer ! </a></p>

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


