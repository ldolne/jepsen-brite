<?php
// ALL CONTROLLERS TO WHICH POINTS THE ROUTER

require('./model/model.php');

// Chargement des classes
//require_once('./model/UserManager.php');
//require_once('./model/CategoryManager.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');

// USER FUNCTIONS

function getInscriptionPage() {
    $message='Complete all the fields';
    $usernameError='';
    $passwordError='';
    $emailError='';
    require('./view/signup.php');
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

    $image = md5(strtolower(trim($email)));


    if($emailValidation == TRUE && $passwordValidation == TRUE && $usernameValidation == TRUE){
        $inscription = inscriptionPreparation();
        $inscription -> execute(array($email, $username, $password, $image));

        $message='Inscription done. Welcome';

        $to      = $email;
        $subject = 'Inscription à Jepsen-brite event ';
        $message = 'La Team-5 est heureuse de t\'acceuillir sur ce magnifique site';
        $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" ;

        mail($to, $subject, $message, $headers);
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
    $request = dbUserVerif();
    $username = htmlspecialchars($_POST['username']);
    //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $request -> execute(array($username));
    $result = $request -> fetch();
    $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
    if ($isPasswordCorrect == false){
        $message = "Cet utilisateur n'existe pas ou ce n'est pas la bonne combinaison";
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
        require('./view/loging.php');
    }
}

function deconnection(){
    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');
    require('./view/deconnectionview.php');
}

function getProfilePage(){
    
    $request = dbuserverif();
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
    $request = dbUserVerif();
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
        $updatePrep = updatePreparation();
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
    $request = dbUserVerif();
    $request -> execute(array($_SESSION['username']));
    $result = $request -> fetch();

    $deletePrep = deletePreparation();
    $deletePrep -> execute(array($result['id']));
    $message = 'Your account was deleted';

    $_SESSION = array();
    session_destroy();
    setcookie('id', '');
    setcookie('username', '');
    
    // peut être remettre une page intermédiaire
    require('./view/mainPage.php');
}

// CATEGORY FUNCTIONS

function AllCategoryController()
{
    $search = AllCategoryModel();
    require('./view/event.php');
}

function OneCategoryController()
{
    $search = OneCategoryModel($_GET['category_id']);
    if ($search === null) {
        echo 'Aucun résultat';
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

function showEvent()
{
    $eventManager = new EventManager();
    $commentManager = new CommentManager();

    $eventReq = $eventManager->getEvent($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);
    $event = $eventReq->fetch();

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
        header('Location: ./index.php?action=showEventCreationPage');
    }
}

function showEventModificationPage($message = null)
{
    // requête SQL pour récuper données et les afficher.
    require('./view/modifyEvent.php');
}

function updateExistingEvent($eventId, $imageName)
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->updateEvent(
        $_POST['title'],
        $_SESSION['id'],
        $_POST['event_date'],
        $_POST['event_hour'],
        $imageName,
        $_POST['description'],
        $_POST['category_id']);

    if ($affectedLines === false) {
        throw new Exception('Problem while modifying the event. Please try again.');
        $result = '<p>Event has NOT been successfully modified.</p>';
        //showEventCreationPage($result);
    } else {
        $result = '<p>Event has been successfully modified.</p>';
        header('Location: ./index.php?action=showEvent&id=' . $eventId);
    }
}

function deleteExistingEvent()
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->deleteEvent($_GET['id']);

    if ($affectedLines === false) {
        throw new Exception('Problem while modifying the event. Please try again.');
        echo '<p>Event has NOT been successfully deleted.</p>';
        //showEventCreationPage($result);
    } else {
        echo '<p>Event has been successfully deleted.</p>';
        //showEventCreationPage($result);
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
