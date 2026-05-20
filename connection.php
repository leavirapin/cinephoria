<?php
session_start();

$db_name = 'mysql:host=localhost;port=8889;dbname=cinephoria;charset=utf8mb4';
$db_user = 'root';
$db_password = 'root';

$conn = new PDO($db_name,$db_user,$db_password);
 
function unique_id(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLengt = strlen($chars);
        $randomString = '';

        for ($i= 0; $i < 20; $i++) {
            $randomString.=$chars[mt_rand(0, $charLengt - 1)];
     } 
     return $randomString;
  } 

?>






























































































