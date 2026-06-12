<?php
session_start();

$db_name = 'mysql:host=sql202.infinityfree.com;dbname=if0_42164512_cinephoria;charset=utf8mb4';
$db_user = 'if0_42164512';
$db_password = 'rpJQCAHBWm9u0';

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





























































































