<?php
include 'connection.php';
session_start();

//1.securite employe
if (
    !isset($_SESSION['user_id']) ||
    !in_array($_SESSION['user_role'], ['admin', 'employe'])
) {
    header('Location: login.php');
    exit;
}

//1.delete avis
if (isset($_GET['delete'])) {
$id = $_GET['delete'];

$delete = $conn->prepare("DELETE FROM avis WHERE idavis = ?");
$delete->execute([$id]);

header('Location: avis.php');
exit;
}

//1.valide avis
if (isset($_GET['valide'])) {
$id = $_GET['valide'];

$update = $conn->prepare("UPDATE avis SET statut = 'valide' WHERE idavis = ?");
$update->execute([$id]);

header('Location: avis.php');
exit;
}

//1.select avis
$select_avis = $conn->prepare("SELECT * FROM avis WHERE statut = 'en_attente' ORDER BY idavis DESC");
$select_avis->execute();
$avis = $select_avis->fetchAll(PDO::FETCH_ASSOC);

//1.foreach avis
foreach ($avis as $avis) {
    echo htmlspecialchars($avis['note'] ?? '');
     echo htmlspecialchars($avis['commentaires'] ?? '');

    echo '<a href="avis.php?delete=' . $avis['idavis'] . '" onclick="return confirm(\'Supprimer cet avis ?\')"> Supprimer</a>';
   echo '<a href="avis.php?valide=' . $avis['idavis'] . '"> Valider </a>';
    
    echo '<br>';
}

?>


