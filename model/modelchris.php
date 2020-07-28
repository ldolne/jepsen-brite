<?php

function calldbo(){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function dbuserverif() {
    // calldbo();
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd-> prepare("SELECT * FROM `users` WHERE `username` = ?");
    return $request;
}

function inscriptionPreparation(){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd-> prepare("INSERT INTO `users`(`email`, `username`, `password`, `avatar`) 
    VALUES(?, ?, ?, ?)");
    return $request;
}

function isNameTaken() {
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd-> prepare("SELECT `username` FROM `users` WHERE `username` = ?");
    return $request;
}

function isEmailTaken() {
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd-> prepare("SELECT `email` FROM `users` WHERE `email` = ?");
    return $request;
}

function updatepreparation() {
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd -> prepare("UPDATE users SET `username` = ?, `password`=? WHERE `id` = ?");
    return $request;
}

function deletePreparation(){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    $request = $bdd -> prepare("DELETE FROM users WHERE `id` = ?");
    return $request;
}