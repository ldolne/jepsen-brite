<?php
function register(){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '');
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    global $data;
    $request = $bdd-> prepare("SELECT username, email FROM `users` WHERE `username` = ? OR `email`=?");
    $requestemail = $bdd -> prepare("SELECT email FROM `users` WHERE `email` = ?");
    $requestusername = $bdd -> prepare("SELECT username FROM `users` WHERE `username` = ?");



    if (isset($_POST['signup'])){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $passwordcheck=$_POST['passwordcheck'];

        $request -> execute(array($_POST['username'], $_POST['email']));
        $data = $request -> fetch();

        $requestusername -> execute(array($_POST['username']));
        $datausername = $requestusername -> fetch();

        $requestemail -> execute(array($_POST['email']));
        $dataemail = $requestemail -> fetch();

        // echo ($data['username'] . " " . $data['email']);


    }

    if (isset($username, $email, $password, $passwordcheck) && filter_var($email, FILTER_VALIDATE_EMAIL) && $password == $passwordcheck && $password != null && isset($datausername['username'])==false && isset($dataemail['email'])==false && preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password'])==true) {
        echo"c'est ok";
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
        $bdd->exec("INSERT INTO `users`(`email`, `username`, `password`, `avatar`) VALUES('$email', '$username', '$hashedpassword', '')");
        
        $to      = $email;
        $subject = 'Inscription à Jepsen-brite event ';
        $message = 'La Team-5 est heureuse de t\'acceuillir sur ce magnifique site';
        $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" ;

        mail($to, $subject, $message, $headers);


    }
    else {
        // echo " erreur ";
    }
    return $request;

}
