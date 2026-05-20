<?php
include 'connection.php';


//1.securite admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: login.php');
    exit;
}


//1.delete film
if (isset($_GET['delete'])) {
$id = (int) $_GET['delete'];

$delete = $conn->prepare("DELETE FROM film WHERE idfilm = ?");
$delete->execute([$id]);

header('Location: admin.php');
exit;
}

//2.delete salle
if (isset($_GET['delete_salle'])) {
$id = (int) $_GET['delete_salle'];

$delete = $conn->prepare("DELETE FROM salle WHERE idsalle = ?");
$delete->execute([$id]);

header('Location: admin.php');
exit;
}

//3.delete seance
if (isset($_GET['delete_seance'])) {
$id = (int) $_GET['delete_seance'];

$delete = $conn->prepare("DELETE FROM seance WHERE idseance = ?");
$delete->execute([$id]);

header('Location: admin.php');
exit;
}

//3.delete employe
if (isset($_GET['delete_employe'])) {
$id = (int) $_GET['delete_employe'];

$delete = $conn->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
$delete->execute([$id]);

header('Location: admin.php');
exit;
}


//1.select film
$select_film = $conn->prepare("SELECT * FROM film ORDER BY date_ajout DESC");
$select_film->execute();
$films = $select_film->fetchAll(PDO::FETCH_ASSOC);

//2.select salle
$select_salle = $conn->prepare("SELECT * FROM salle");
$select_salle->execute();
$salles = $select_salle->fetchAll(PDO::FETCH_ASSOC);

//3.select seance
$select_seance= $conn->prepare("SELECT * FROM seance");
$select_seance->execute();
$seances = $select_seance->fetchAll(PDO::FETCH_ASSOC);

//4.select employe
$select_employe= $conn->prepare("SELECT * FROM utilisateur WHERE role = 'employe'");
$select_employe->execute();
$employes = $select_employe->fetchAll(PDO::FETCH_ASSOC);



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
            <h1>Administration</h1>
        </div>

        <div class="box d-flex flex-wrap gap-3 mt-4">
            <a href="add_film.php" class="btn">Ajouter un film</a>
            <a href="add_salle.php" class="btn">Ajouter une salle</a>
            <a href="add_seance.php" class="btn">Ajouter une séance</a>
            <a href="add_employe.php" class="btn">Ajouter un employé</a>
        </div>


            <div class="table-responsive">
                <h1 class="text-center mb-4">GESTION DES FILMS</h1>
                <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Genre</th>
                                <th>Date ajout</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($films as $film) { ?>
                        <tr>
                            <td><?= htmlspecialchars($film['titre']) ?></td>
                            <td><?= htmlspecialchars($film['genre']) ?></td>
                            <td><?= htmlspecialchars($film['date_ajout']) ?></td>

                            <td class="d-flex gap-2">
                                <a href="edit_film.php?idfilm=<?= (int) $film['idfilm'] ?>" class="btn btn-warning">Modifier</a>
                                <a href="admin.php?delete=<?= (int) $film['idfilm'] ?>" class="btn btn-danger"onclick="return confirm('Supprimer ce film?')">Supprimer</a>
                            </td> 
                        </tr>
                       <?php } ?>
                    </tbody>
                </table>
            </div> 


             <div class="table-responsive">
                <h1 class="text-center mb-4">GESTION DES SALLES</h1>
                <table class="table table-dark table-hover align-middle">
                     <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Nombre de siège</th>
                                <th>Qualité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                    <tbody>
                        <?php foreach ($salles as $salle) { ?>
                        <tr>
                
                            <td><?= htmlspecialchars($salle['Nom']) ?></td>
                            <td><?= htmlspecialchars($salle['Nombre_de_siege']) ?></td>
                            <td><?= htmlspecialchars($salle['qualite']) ?></td>

                            <td class="d-flex gap-2">
                                <a href="edit.salle.php?idsalle=<?= (int) $salle['idsalle'] ?>" class="btn btn-warning">Modifier</a>
                                <a href="admin.php?delete_salle=<?= (int) $salle['idsalle'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette salle?')">
                            Supprimer
                                </a>
                            </td> 
                        </tr>
                         <?php } ?>
                    </tbody>
                </table>
            </div> 


             <div class="table-responsive">
                <h1 class="text-center mb-4">GESTION DES SEANCES</h1>
                <table class="table table-dark table-hover align-middle">
                     <thead>
                            <tr>
                                <th>Films</th>
                                <th>Date et heure</th>
                                <th>Salle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                    <tbody>
                        <?php foreach ($seances as $seance) { ?>
                        <tr>
                
                            <td><?= htmlspecialchars($seance['id_film']) ?></td>
                            <td><?= htmlspecialchars($seance['date_heure']) ?></td>
                            <td><?= htmlspecialchars($seance['id_salle']) ?></td>

                            <td class="d-flex gap-2">
                                <a href="edit.seance.php?idseance=<?= (int) $seance['idseance'] ?>" class="btn btn-warning">Modifier</a>
                                <a href="admin.php?delete_seance=<?= (int) $seance['idseance'] ?>" class="btn btn-danger"onclick="return confirm('Supprimer cette                         seance?')">
Supprimer
</a>
                            </td> 
                        </tr>
                         <?php } ?>
                    </tbody>
                </table>
            </div> 


                <div class="table-responsive">
                <h1 class="text-center mb-4">GESTION DES EMPLOYES</h1>
                <table class="table table-dark table-hover align-middle">
                     <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                    <tbody>
                        <?php foreach ($employes as $employe) { ?>
                        <tr>
                
                            <td><?= htmlspecialchars($employe['nom']) ?></td>
                            <td><?= htmlspecialchars($employe['prenom']) ?></td>
                            <td><?= htmlspecialchars($employe['email']) ?></td>

                            <td class="d-flex gap-2">
                                <a href="edit_employe.php?id_utilisateur=<?=(int) $employe['id_utilisateur'] ?>" class="btn btn-warning">Modifier</a>
                                <a href="admin.php?delete_employe=<?= (int) $employe['id_utilisateur'] ?>" class="btn btn-danger"onclick="return confirm('Supprimer cet employe?')">Supprimer</a>
                            </td> 
                        </tr>
                         <?php } ?>
                    </tbody>
                </table>
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


