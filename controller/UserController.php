<?php

// USER CONTROLLERS

namespace controller;

use SendGrid\Content;
use SendGrid\Email;
use SendGrid\Mail;

require_once('./vendor/autoload.php');
require_once('./autoloader.php');
require_once('./model/UserManager.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');

class UserController
{
    private $userManager;
    private $eventManager;
    private $commentManager;

    public function __construct()
    {
        $this->userManager = new \model\UserManager();
        $this->eventManager = new \model\EventManager();
        $this->commentManager = new \model\CommentManager();
    }

    public function cookieVerification() {
        $request = $this->userManager-> DoesCookieUserExist();
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
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $passwordRaw = $_POST['password'];
        $passwordcheck = $_POST['passwordcheck'];

        $request = $this->userManager->isNameTaken();
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
            $request = $this->userManager->isEmailTaken();
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
            $inscription = $this->userManager->inscriptionPreparation();
            $inscription -> execute(array($email, $username, $password, $image));

            $message='Inscription successful. Welcome';
            $message = showInfoMessage($message, true);

            // Sending welcome email
            // uncomment for Heroku

            /*$from = new Email(null, "becodechristest@gmail.com");
            $subject = 'Inscription à Jepsen-brite event ';
            $to = new Email(null, $email);
            $content = new Content("text/plain", 'Team-5 is happy to welcome your on their website!');
            $mail = new Mail($from, $subject, $to, $content);

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
        $request = $this->userManager->dbUserVerif();
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
        $request = $this->userManager->dbUserVerif();
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
        $request = $this->userManager->dbUserVerif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();

        if (isset($_POST['username']) && !empty($_POST['username'])){
            $username= htmlspecialchars($_POST['username']);

            $request2 = $this->userManager->isNameTaken();
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
            $updatePrep = $this->userManager->updatePreparation();
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
        $request = $this->userManager->dbUserVerif();
        $request -> execute(array($_SESSION['username']));
        $result = $request -> fetch();

        // Update user's events and comments
        $eventsAffectedLines = $this->eventManager->updateEventAuthorWhenDeletedAccount($result['id']);
        $commentsAffectedLines = $this->commentManager->updateCommentAuthorWhenDeletedAccount($result['id']);

        if ($eventsAffectedLines === false) {
            throw new \Exception("Problem while deleting the user's events. Please try again.");
        } else if ($commentsAffectedLines === false)
        {
            throw new \Exception("Problem while deleting the user's comments. Please try again.");
        }

        // Delete user
        $deletePrep = $this->userManager->deletePreparation();
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
        $request = $this->userManager->getUser(); //TODO Caro
        $request -> execute(array($_SESSION['id']));
        $result = $request -> fetch();

        $userId = $result['id'];

        $userEvents = $this->eventManager->getUserEvents($userId);
        $pastParticip = $this->eventManager->getPastParticip($userId);
        $upcomingParticip = $this->eventManager->getUpcomingParticip($userId);

        require('./view/userDashboard.php');
    }

    public function getAdminDashboard()
    {
        $getUsers = $this->userManager->getUsers();
        $usersArr = $getUsers->fetchAll();

        require('./view/adminDashboard.php');
    }

    function makeAdmin()
    {
        $getUser = $this->userManager->getUser();
        $getUser->execute(array($_GET['id']));
        $user = $getUser -> fetch();

        $toAdmin = $this->userManager->promoteToAdmin($user['id']);

        header('Location: ./index.php?action=admindashboard');
    }

    function undoAdmin()
    {
        $getUser = $this->userManager->getUser();
        $getUser->execute(array($_GET['id']));
        $user = $getUser -> fetch();

        $fromAdmin = $this->userManager->demoteFromAdmin($user['id']);

        header('Location: ./index.php?action=admindashboard');
    }

    function adminDeleteUser()
    {
        $getUser = $this->userManager->getUser();
        $getUser->execute(array($_GET['id']));
        $user = $getUser -> fetch();

        // Update user's events and comments
        $eventsAffectedLines = $this->eventManager->updateEventAuthorWhenDeletedAccount($user['id']);
        $commentsAffectedLines = $this->commentManager->updateCommentAuthorWhenDeletedAccount($user['id']);

        if ($eventsAffectedLines === false) {
            throw new \Exception("Problem while deleting the user's events. Please try again.");
        } else if ($commentsAffectedLines === false)
        {
            throw new \Exception("Problem while deleting the user's comments. Please try again.");
        }

        // Delete user
        $deleteByAdmin = $this->userManager->deleteUserByAdmin();
        $deleteByAdmin->execute(array($user['id']));
        $message = 'The account was deleted';
        $message = showInfoMessage($message, True);

        header('Location: ./index.php?action=admindashboard');
    }
}