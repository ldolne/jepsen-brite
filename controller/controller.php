<?php
// ALL CONTROLLERS TO WHICH POINTS THE ROUTER

// Chargement des classes
require_once('./model/UserManager.php');
require_once('./model/CategoryManager.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');

// Autres
require_once('./require/functions.php');

// uncomment for Heroku
// require 'vendor/autoload.php'; 

// USER FUNCTIONS
function cookieVerification() {
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

function getInscriptionPage() {
    $message='Complete all the fields';
    showInfoMessage($message, False);
    $usernameError='';
    $passwordError='';
    $emailError='';
    require('./view/signup.php');
}

function actualInscription() {
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
        $passwordError = 'The password are not the same';
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
            $emailError ='This Email is already taken';
        }
    }
    else {
        $emailValidation = FALSE;
        $emailError='this email adress is not a valid one';
    }

    $image = md5(strtolower(trim($email)));

    if($emailValidation == TRUE && $passwordValidation == TRUE && $usernameValidation == TRUE){
        $inscription = $userManager->inscriptionPreparation();
        $inscription -> execute(array($email, $username, $password, $image));

        $message='Inscription done. Welcome';
        showInfoMessage($message, true);

        // uncomment for Heroku

        // $from = new SendGrid\Email(null, "becodechristest@gmail.com");
        // $subject = 'Inscription à Jepsen-brite event ';
        // $to = new SendGrid\Email(null, $email);
        // $content = new SendGrid\Content("text/plain", 'La Team-5 est heureuse de t\'acceuillir sur ce magnifique site');
        // $mail = new SendGrid\Mail($from, $subject, $to, $content);

        // $apiKey = getenv('SENDGRID_API_KEY');
        // $sg = new \SendGrid($apiKey);

        // $response = $sg->client->mail()->send()->post($mail); 

        require('./view/signup.php');

    }
    else {
        $message = '';
        require('./view/signup.php');
    }
}

function getConnectionPage() {
    $message ='';
    require('./view/loging.php');
}

function login() {
    $userManager = new UserManager();

    $request = $userManager->dbUserVerif();
    $username = htmlspecialchars($_POST['username']);
    //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $request -> execute(array($username));
    $result = $request -> fetch();
    if (isset($result['password'])) {

        $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
        if ($isPasswordCorrect == false){
            $message = "Cet utilisateur n'existe pas ou ce n'est pas la bonne combinaison";
            showInfoMessage($message, False);
            require('./view/loging.php');
        }
        else {
            $_SESSION["id"]= $result['id'];
            $_SESSION["username"]= $result['username'];
            if (isset($_POST['stayconnected'])){
                setcookie('id', $result['id'], time() + 30*24*3600, null, null, false, true);
                setcookie('username', $result['username'], time() + 30*24*3600, null, null, false, true);
            }
            $message= "Connection réussie";
            showInfoMessage($message, True);
            require('./view/loging.php');
        }
    }
    else {
        $message = "Cet utilisateur n'existe pas ou ce n'est pas la bonne combinaison";
        require('./view/loging.php');
    }
}

function deconnection(){
    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');
    header('Location: ./index.php');
}

function getProfilePage(){
    $userManager = new UserManager();
    $request = $userManager->dbUserVerif();
    $request -> execute(array($_SESSION['username']));
    $result = $request -> fetch();
    require('./view/profil.php'); 
}

function modifyProfilePage(){
    $message='';
    $passwordError = '';
    $usernameError ='';
    require('./view/modifyprofileview.php');
    
}

function profileModification() {
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
        $message = 'Modifications done';
        showInfoMessage($message, True);
        $updatePrep = $userManager->updatePreparation();
        $updatePrep -> execute(array($username, $password, $result['id']));
        
        $_SESSION["username"]= $username;
        if (isset($_POST['stayconnected'])){
            setcookie('username', $username, time() + 30*24*3600, null, null, false, true);
        }
        require('./view/modifyprofileview.php');
    }
    else{
        $message = '';
        require('./view/modifyprofileview.php');
    }    
}

function deleteAccount(){
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
    showInfoMessage($message, True);

    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');

    // Renvoi à l'homepage
    header('Location: ./index.php');
}

// CATEGORY FUNCTIONS

function AllCategoryController()
{
    $categoryManager = new CategoryManager();
    $search = $categoryManager->AllCategoryModel();
    require('./view/event.php');
}

function OneCategoryController()
{
    $categoryManager = new CategoryManager();
    $search = $categoryManager->OneCategoryModel($_GET['category_id']);
    if ($search === null) {
        throw new Exception('No result.');
    } else {
        require('./view/event.php');
    }
}

// EVENT AND COMMENT FUNCTIONS

function getIndexPage(){
    $eventManager = new EventManager(); // création de l'objet
    $events = $eventManager->getUpcomingEvents(); // appel d'une fonction de cet objet

    require('./view/mainPage.php');
}

function listPastEvents()
{
    $eventManager = new EventManager(); // création de l'objet
    $events = $eventManager->getPastEvents(); // appel d'une fonction de cet objet

    require('./view/archiveView.php');
}

function showEvent($message = NULL)
{
    $eventManager = new EventManager();
    $commentManager = new CommentManager();

    $eventReq = $eventManager->getEvent($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);
    $userAvatarReq = $commentManager->getCurrentCommentAuthorAvatar($_SESSION['id']);

    $event = $eventReq->fetch();
    $userAvatar = $userAvatarReq->fetch();

    if (!empty($event))
    {
        require('./view/oneEvent.php');
    }
    else
    {
        throw new Exception('Event ID does not exist.');
    }
}

function handleEvent()
{
    $eventManager = new EventManager();

    $eventReq = $eventManager->getEvent($_GET['id']);
    $event = $eventReq->fetch();

    if (empty($event))
    {
        throw new Exception('Event ID does not exist.');
    }
    else
    {
        return $event;
    }
}

function showEventCreationPage($message = null)
{
    require('./view/addEvent.php');
}

function createNewEvent($imageName)
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->createEvent(
        $_POST['title'],
        $_SESSION['id'],
        $_POST['event_date'],
        $_POST['event_hour'],
        $imageName,
        $_POST['description'],
        $_POST['category_id']);

    if ($affectedLines === false) {
        throw new Exception('Problem while creating an event. Please try again.');
    }
    else
    {
        header('Location: ./index.php');
    }
}

function showEventModificationPage($event, $message = null)
{
    require('./view/modifyEvent.php');
}

function updateExistingEvent($imageName)
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->updateEvent(
        $_GET['id'],
        $_POST['title'],
        $_SESSION['id'],
        $_POST['event_date'],
        $_POST['event_hour'],
        $imageName,
        $_POST['description'],
        $_POST['category_id']);

    if ($affectedLines === false) {
        throw new Exception('Problem while modifying the event. Please try again.');
    } else {
        header('Location: ./index.php?action=showEvent&id=' . $_GET['id']);
    }
}

function deleteExistingEvent()
{
    $eventManager = new EventManager();
    $commentManager = new CommentManager();
    $EventsAffectedLines = $eventManager->deleteEvent($_GET['id']);
    $CommentsAffectedLines = $commentManager->deleteAllComments($_GET['id']);

    if ($EventsAffectedLines === false) {
        throw new Exception('Problem while deleting the event. Please try again.');
    } else if ($CommentsAffectedLines === false)
    {
        throw new Exception('Problem while deleting the comments of the event. Please try again.');
    } else {
        header('Location: ./index.php');
    }
}

function addComment($eventId, $authorId, $comment)
{
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->postComment($eventId, $authorId, $comment);

    if ($affectedLines === false) {
        throw new Exception('Problem while adding a comment. Please try again.');
    } else {
        header('Location: ./index.php?action=showEvent&id=' . $eventId);
    }
}

/*function deleteComment($eventId, $commentId)
{
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->deleteOneComment($commentId);

    if ($affectedLines === false) {
        throw new Exception('Problem while adding a comment. Please try again.');
    } else {
        header('Location: ./index.php?action=showEvent&id=' . $eventId);
    }
}*/
