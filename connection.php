<?php
session_start();

$db_name = 'mysql:host=acela.proxy.rlwy.net;port=28901;dbname=railway;charset=utf8mb4';
$db_user = 'root';
$db_password = 'kNkXlDMOibBroYoyTCFeDdsvGweAIdsT';

try {

    $conn = new PDO($db_name, $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){

    die("Erreur connexion : " . $e->getMessage());

}

function unique_id(){

    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLengt = strlen($chars);
    $randomString = '';

    for ($i = 0; $i < 20; $i++) {

        $randomString .= $chars[mt_rand(0, $charLengt - 1)];

    }

    return $randomString;

}

?>





















































































