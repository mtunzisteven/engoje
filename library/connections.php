<?php

/*
Proxy connection to the engoje database
*/

function engojeConnect(){
    $server ='localhost';
    $dbname = 'mediafs0_comza';
    $username = 'mediafs0_mtunzism';
    $password = 'NtandoMilaniImani321.';
    $dsn = "mysql:host=$server; dbname=$dbname";
    $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    //create the actual connection object and assign it to a variable
    try{
        $link = new PDO($dsn, $username, $password, $option);
        return $link;
    }catch(PDOException $e){
        
        header('Location: /error/500.php');
        exit;
    }

}

