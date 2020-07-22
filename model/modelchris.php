<?php
function register(){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    global $data;
    $request = $bdd-> prepare("SELECT username, email FROM `users` WHERE `username` = ? OR `email`=?");
    // $requestemail = $bdd -> prepare("SELECT email FROM `users` WHERE `email` = ?");


    if (isset($_POST['signup'])){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $passwordcheck=$_POST['passwordcheck'];

        $request -> execute(array($_POST['username'], $_POST['email']));
        $data = $request -> fetch();

        // $requestemail -> execute(array($_POST['email']));
        // global $dataemail;
        // $dataemail = $requestemail -> fetch();

        echo ($data['username'] . " " . $data['email']);


    }

    if (isset($username, $email, $password, $passwordcheck) && filter_var($email, FILTER_VALIDATE_EMAIL) && $password == $passwordcheck && $password != null && isset($dataname['username'])==false && isset($data['name'])==false && isset($data['email'])==false) {
        echo"c'est ok";

    }

    else {
        echo " erreur ";
    }
    return $request;

}