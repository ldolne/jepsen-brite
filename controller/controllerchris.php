<?php

require('./model/modelchris.php');

function getindexpage(){
    require('./view/mainpagechrisview.php');
}

function getinscriptionpage() {
    $message='Complete all the fields';
    $usernameError='';
    $passwordError='';
    $emailError='';
    require('./view/inscriptionview.php');
}

function actualInscription() {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $passwordRaw = $_POST['password'];
    $passwordcheck = $_POST['passwordcheck'];
        
    $request = isNameTaken();
    $request -> execute(array($username));
    $isNameTaken = $request -> fetch();

    if ($isNameTaken == Null){
        $usernameValidation = TRUE;
        $usernameError = '';
    }
    else{
        $usernameValidation = FALSE;
        $usernameError = 'This username is already taken';
    }

    if ($passwordRaw == $passwordcheck){
        if (preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $passwordRaw)==true){
            $passwordValidation = TRUE;
            $passwordError = '';
            $password = password_hash($passwordRaw, PASSWORD_BCRYPT);
        }
        else{
            $passwordError = 'This password is not safe enough';
            $passwordValidation = FALSE;
        }
    }
    else {
        $passwordError = 'The password are not the same';
        $passwordValidation = FALSE;
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == true){
        $request = isEmailTaken();
        $request -> execute(array($email));
        $isEmailTaken = $request -> fetch();
        
        if ($isEmailTaken == Null){
            $emailValidation = TRUE;
            $emailError ='';
        }
        else {
            $emailValidation = FALSE;
            $emailError ='This Email is already taken';
        }
    }
    else {
        $emailValidation = FALSE;
        $emailError='this email adress is not a valid one';
    }

    if($emailValidation == TRUE && $passwordValidation == TRUE && $usernameValidation == TRUE){
        $inscription = inscriptionPreparation();
        $inscription -> execute(array($email, $username, $password));

        $message='Inscription done. Welcome';

        $to      = $email;
        $subject = 'Inscription à Jepsen-brite event ';
        $message = 'La Team-5 est heureuse de t\'acceuillir sur ce magnifique site';
        $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" ;

        mail($to, $subject, $message, $headers);
        require('./view/inscriptionview.php');

    }
    else {
        $message = '';
        require('./view/inscriptionview.php');
    }
}

function getconnectionpage() {
    $message ='';
    require('./view/connectionview.php');
}

function login() {
    $request = dbuserverif();
    $username = htmlspecialchars($_POST['username']);
    //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $request -> execute(array($username));
    $result = $request -> fetch();
    $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
    if ($isPasswordCorrect == false){
        $message = "Cet utilisateur n'existe pas ou ce n'est pas la bonne combinaison";
        require('./view/connectionview.php');
    }
    else {
        $_SESSION["id"]= $result['id'];
        $_SESSION["username"]= $result['username'];
        if (isset($_POST['stayconnected'])){
            setcookie('id', $result['id'], time() + 30*24*3600, null, null, false, true);
            setcookie('username', $result['username'], time() + 30*24*3600, null, null, false, true);
        }
        $message= "Connection réussie " . $_SESSION['username'];
        require('./view/connectionview.php');
    }
}

function deconnection(){
    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');
    require('./view/deconnectionview.php');
}

function getprofilepage(){
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
        $request = dbuserverif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();
        require('./view/profileview.php');
    }

    else {
        $message="vous n'avez pas accès à cette page.";
        require('./view/errorview.php');
    }
}

function modifyprofilepage(){
    $message='';
    $passwordError = '';
    $usernameError ='';
    require('./view/modifyprofileview.php');
    
}

function profilemodification() {
    $request = dbuserverif();
    $request -> execute(array($_SESSION['username']));
    $result = $request -> fetch();
    
    if (isset($_POST['username']) && !empty($_POST['username'])){
        $username= htmlspecialchars($_POST['username']);
        
        $request2 = isNameTaken();
        $request2 -> execute(array($username));
        $isNameTaken = $request2 -> fetch();

        if ($isNameTaken == Null){
            $usernameValidation = TRUE;
            $usernameError = '';
        }
        else{ 
            $usernameValidation = FALSE;
            $usernameError = 'This username is already taken';
        }
    }
    else{
        $username=$result['username'];
        $usernameValidation = TRUE;
        $usernameError = '';
    }

    if (isset($_POST['password']) && !empty($_POST['password'])){
        $passwordRaw= htmlspecialchars($_POST['password']);
        
        if (preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $passwordRaw)==true){
            $passwordValidation = TRUE;
            $passwordError = '';
        }
        else{
            $passwordError = 'This password is not safe enough';
            $passwordValidation = FALSE;
        }
        $password = password_hash($passwordRaw, PASSWORD_BCRYPT);
    }
    else{
        $password=$result['password'];
        $passwordValidation = TRUE;
        $passwordError='';
    }
    

    if ($passwordValidation == TRUE && $usernameValidation == TRUE){
        $message = 'Modifications done';
        $updatePrep = updatepreparation();
        $updatePrep -> execute(array($username, $password, $result['id']));
        require('./view/modifyprofileview.php');
    }
    else{
        $message = '';
        require('./view/modifyprofileview.php');
    }    
}