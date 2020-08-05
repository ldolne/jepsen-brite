<?php

// USER CONTROLLERS

namespace controller;

require_once('autoloader.php');

class UserController
{
    public function cookieVerification() {
        $userManager = new UserManager();

        $request = $userManager-> DoesCookieUserExist();
        $request -> execute(array($_COOKIE['id'], $_COOKIE['username']));
        $isTheCookieALie = $request -> fetch();

        if (isset($isTheCookieALie) && !empty($isTheCookieALie)){
            $_SESSION['username']= $_COOKIE['username'];
            $_SESSION['id']= $_COOKIE['id'];
        }

        else {
            $_SESSION['username']= '';
            $_SESSION['id']= '';
            setcookie('id', '');
            setcookie('username', '');
        }
    }

    public function getInscriptionPage() {
        $message='Complete all the fields';
        $message = showInfoMessage($message, False);
        $usernameError='';
        $passwordError='';
        $emailError='';
        require('./view/signup.php');
    }

    public function actualInscription() {
        $userManager = new UserManager();

        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $passwordRaw = $_POST['password'];
        $passwordcheck = $_POST['passwordcheck'];

        $request = $userManager->isNameTaken();
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
            $passwordError = 'The password fields are not identical';
            $passwordValidation = FALSE;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == true){
            $request = $userManager->isEmailTaken();
            $request -> execute(array($email));
            $isEmailTaken = $request -> fetch();

            if ($isEmailTaken == Null){
                $emailValidation = TRUE;
                $emailError ='';
            }
            else {
                $emailValidation = FALSE;
                $emailError ='This email address is already taken';
            }
        }
        else {
            $emailValidation = FALSE;
            $emailError='This email address is not a valid one';
        }

        $image = md5(strtolower(trim($email)));

        if($emailValidation == TRUE && $passwordValidation == TRUE && $usernameValidation == TRUE){
            $inscription = $userManager->inscriptionPreparation();
            $inscription -> execute(array($email, $username, $password, $image));

            $message='Inscription successful. Welcome';
            $message = showInfoMessage($message, true);

            // uncomment for Heroku

            /*$from = new SendGrid\Email(null, "becodechristest@gmail.com");
            $subject = 'Inscription à Jepsen-brite event ';
            $to = new SendGrid\Email(null, $email);
            $content = new SendGrid\Content("text/plain", 'Team-5 is happy to welcome your on their website!');
            $mail = new SendGrid\Mail($from, $subject, $to, $content);

            $apiKey = getenv('SENDGRID_API_KEY');
            $sg = new \SendGrid($apiKey);

            $response = $sg->client->mail()->send()->post($mail);*/

            require('./view/signup.php');

        }
        else {
            $message = '';
            require('./view/signup.php');
        }
    }

    public function getConnectionPage() {
        $message ='';
        require('./view/login.php');
    }

    public function login() {
        $userManager = new UserManager();

        $request = $userManager->dbUserVerif();
        $username = htmlspecialchars($_POST['username']);
        //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $request -> execute(array($username));
        $result = $request -> fetch();
        if (isset($result['password'])) {

            $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
            if ($isPasswordCorrect == false){
                $message = "This user doesn't exist or this is not the right password";
                $message = showInfoMessage($message, False);
                require('./view/login.php');
            }
            else {
                $_SESSION["id"]= $result['id'];
                $_SESSION["username"]= $result['username'];
                if (isset($_POST['stayconnected'])){
                    setcookie('id', $result['id'], time() + 30*24*3600, null, null, false, true);
                    setcookie('username', $result['username'], time() + 30*24*3600, null, null, false, true);
                }
                $message= "Connection successful";
                $message = showInfoMessage($message, true);
                require('./view/login.php');
            }
        }
        else {
            $message = "This user doesn't exist or this is not the right password";
            require('./view/login.php');
        }
    }

    public function deconnection(){
        $_SESSION = array();
        session_destroy();
        setcookie('id', '');
        setcookie('username', '');
        header('Location: ./index.php');
    }

    public function getProfilePage(){
        $userManager = new UserManager();
        $request = $userManager->dbUserVerif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();
        require('./view/profil.php');
    }

    public function modifyProfilePage(){
        $message='';
        $passwordError = '';
        $usernameError ='';
        require('./view/modifyProfileView.php');
    }

    public function profileModification() {
        $userManager = new UserManager();
        $request = $userManager->dbUserVerif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();

        if (isset($_POST['username']) && !empty($_POST['username'])){
            $username= htmlspecialchars($_POST['username']);

            $request2 = $userManager->isNameTaken();
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
            $message = 'Modifications successful';
            $message = showInfoMessage($message, True);
            $updatePrep = $userManager->updatePreparation();
            $updatePrep -> execute(array($username, $password, $result['id']));

            $_SESSION["username"]= $username;
            if (isset($_POST['stayconnected'])){
                setcookie('username', $username, time() + 30*24*3600, null, null, false, true);
            }
            require('./view/modifyProfileView.php');
        }
        else{
            $message = '';
            require('./view/modifyProfileView.php');
        }
    }

    public function deleteAccount(){
        $userManager = new UserManager();
        $eventManager = new EventManager();
        $commentManager = new CommentManager();

        $request = $userManager->dbUserVerif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();

        // Update user's events and comments
        $eventsAffectedLines = $eventManager->updateEventAuthorWhenDeletedAccount($result['id']);
        $commentsAffectedLines = $commentManager->updateCommentAuthorWhenDeletedAccount($result['id']);

        if ($eventsAffectedLines === false) {
            throw new Exception("Problem while deleting the user's events. Please try again.");
        } else if ($commentsAffectedLines === false)
        {
            throw new Exception("Problem while deleting the user's comments. Please try again.");
        }

        // Delete user
        $deletePrep = $userManager->deletePreparation();
        $deletePrep -> execute(array($result['id']));
        $message = 'Your account was deleted';
        $message = showInfoMessage($message, True);

        $_SESSION = array();
        session_destroy();
        setcookie('id', '');
        setcookie('username', '');

        // Renvoi à l'homepage
        header('Location: ./index.php');
    }

    public function getUserDashboard(){

        // get created events
        $userManager = new UserManager();
        $request = $userManager->getUserId();
        $request -> execute(array($_SESSION['id']));
        $result = $request -> fetch();

        $userId = $result['id'];

        $eventManager = new EventManager();
        $userEvents = $eventManager->getUserEvents($userId);

        $getPast = new EventManager();
        $pastParticip = $getPast->getPastParticip($userId);

        $getUp = new EventManager();
        $upcomingParticip = $getPast->getUpcomingParticip($userId);

        require('./view/userDashboard.php');
    }
}