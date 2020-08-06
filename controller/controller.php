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
//require 'vendor/autoload.php';

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
    $message = showInfoMessage($message, False);
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

function getConnectionPage() {
    $message ='';
    require('./view/login.php');
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
    require('./view/modifyProfileView.php');
    
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

function deleteAccount(){
    $userManager = new UserManager();
    $eventManager = new EventManager();
    $commentManager = new CommentManager();

    $request = $userManager->dbUserVerif();
    $request -> execute(array($_SESSION['username']));
    $result = $request -> fetch();

    // Update user's events and comments
    $eventsAffectedLines = $eventManager->updateauthorManagerWhenDeletedAccount($result['id']);
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
    $message = 'The account was deleted';
    $message = showInfoMessage($message, True);

    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');

    // Renvoi à l'homepage
    header('Location: ./index.php');
}

function getUserDashboard()
{
    // get created events
    $userManager = new UserManager();
    $request = $userManager->getUser();
    $request -> execute(array($_SESSION['id']));
    $result = $request -> fetch();

    $userId = $result['id'];

    $eventManager = new EventManager(); 
    $userEvents = $eventManager->getUserEvents($userId);
    $pastParticip = $eventManager->getPastParticip($userId);
    $upcomingParticip = $eventManager->getUpcomingParticip($userId);

    require('./view/userDashboard.php');
}

function getAdminDashboard()
{
    $userManager = new UserManager();
    $getUsers = $userManager->getUsers();
    $usersArr = $getUsers->fetchAll();

    require('./view/adminDashboard.php');
}

function makeAdmin()
{
    $userManager = new UserManager();
    $getUser = $userManager->getUser();
    $getUser->execute(array($_GET['id']));
    $user = $getUser -> fetch();

    $toAdmin = $userManager->promoteToAdmin($user['id']);

    header('Location: ./index.php?action=admindashboard');
}

function undoAdmin()
{
    $userManager = new UserManager();
    $getUser = $userManager->getUser();
    $getUser->execute(array($_GET['id']));
    $user = $getUser -> fetch();

    $fromAdmin = $userManager->demoteFromAdmin($user['id']);

    header('Location: ./index.php?action=admindashboard');
}

function adminDeleteUser()
{
    $userManager = new UserManager();
    $eventManager = new EventManager();
    $commentManager = new CommentManager();

    $getUser = $userManager->getUser();
    $getUser->execute(array($_GET['id']));
    $user = $getUser -> fetch();

    // Update user's events and comments
    $eventsAffectedLines = $eventManager->updateauthorManagerWhenDeletedAccount($user['id']);
    $commentsAffectedLines = $commentManager->updateCommentAuthorWhenDeletedAccount($user['id']);

    if ($eventsAffectedLines === false) {
        throw new Exception("Problem while deleting the user's events. Please try again.");
    } else if ($commentsAffectedLines === false)
    {
        throw new Exception("Problem while deleting the user's comments. Please try again.");
    }

    // Delete user
    $deleteByAdmin = $userManager->deleteUserByAdmin($user['id']);
    $message = 'The account was deleted';
    $message = showInfoMessage($message, True);

    header('Location: ./index.php?action=admindashboard');
}

// CATEGORY FUNCTIONS
function AllCategoryController()
{
    $categoryManager = new CategoryManager();
    $search = $categoryManager->AllCategoryModel();
    require('./view/eventsByCategory.php');
}

function OneCategoryController()
{
    $categoryManager = new CategoryManager();
    $search = $categoryManager->OneCategoryModel($_GET['category_id']);
    if ($search === null) {
        throw new Exception('No result.');
    } else {
        require('./view/eventsByCategory.php');
    }
}

// EVENT AND COMMENT FUNCTIONS

function getIndexPage(){
    $eventManager = new EventManager(); // creation of the object
    $events = $eventManager->getUpcomingEvents(); // call a function of this object

    require('./view/mainPage.php');
}

function listPastEvents()
{
    $eventManager = new EventManager(); 
    $events = $eventManager->getPastEvents(); 

    require('./view/archiveView.php');
}

function showEvent($message = NULL)
{
    $eventManager = new EventManager();
    $commentManager = new CommentManager();

    $eventReq = $eventManager->getEvent($_GET['id']);
    $participants = $eventManager->getParticipantsByEvent($_GET['id']);
    $participantsArr = $participants->fetchAll();
    $comments = $commentManager->getComments($_GET['id']);

    if(isset($_SESSION['id']))
    {
        $userAvatarReq = $commentManager->getCurrentCommentAuthorAvatar($_SESSION['id']);
        $userAvatar = $userAvatarReq->fetch();

        // Get if the user of the session in an admin
        $userManager = new UserManager();
        $userReq = $userManager->getUser();
        $userReq -> execute(array($_SESSION['id']));
        $getAdmin = $userReq -> fetch(); 
        $isAdmin = $getAdmin['isadmin'];
    }
    $event = $eventReq->fetch();

    // Get if the author of the event is an admin
   /* $authorManager = new UserManager();
    $authorReq = $authorManager->getUser();
    $authorReq->execute(array($event['author_id']));
    $getAuthor = $authorReq->fetch();
    $authorAdmin = $getAuthor['isadmin'];*/

    //Get if the participant is an admin
    /*foreach($participantsArr as $parti)
    {
        $particManager = new UserManager();
        $particReq = $particManager->getUser();
        $particReq->execute(array($parti['user_id']));
        $getParticipant = $particReq->fetch();
        $particAdmin = $getParticipant['isadmin'];

    }*/

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

function registerToEvent($eventId, $userId)
{
    $eventManager = new EventManager();

    // Check if user's already taking part in the event
    $existingParticipantReq = $eventManager->getOneParticipantByEvent($eventId, $userId);
    $existingParticipant = $existingParticipantReq->fetch();

    if($existingParticipant != false)
    {
        throw new Exception("You're already participating, so you can't register again.");
    }
    else
    {
        // User's not yet participating
        $affectedLines = $eventManager->createParticipantByEvent($eventId, $userId);

        if ($affectedLines === false) {
            throw new Exception('Problem while registering for this event. Please try again.');
        } else {
            header('Location: ./index.php?action=showEvent&id=' . $eventId . '&isParticipating=true');
        }
    }
}

function unregisterFromEvent($eventId, $userId)
{
    $eventManager = new EventManager();

    // Check if user's indeed taking part in the event
    $existingParticipantReq = $eventManager->getOneParticipantByEvent($eventId, $userId);
    $existingParticipant = $existingParticipantReq->fetch();

    if($existingParticipant === false)
    {
        throw new Exception("You're not participating, so you can't unregister.");
    }
    else
    {
        $affectedLines = $eventManager->deleteParticipantByEvent($eventId, $userId);

        if ($affectedLines === false) {
            throw new Exception('Problem while unregistrering from this event. Please try again.');
        } else {
            header('Location: ./index.php?action=showEvent&id=' . $eventId);
        }
    }
}
