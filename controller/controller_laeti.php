<?php

// ALL CONTROLLERS TO WHICH POINTS THE ROUTER

// Version avec classes, avec fonctions

// Chargement des classes
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');

function listUpcomingEvents()
{
    $eventManager = new EventManager(); // création de l'objet
    $events = $eventManager->getUpcomingEvents(); // appel d'une fonction de cet objet

    require('./view/homepageView.php');
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
        require('./view/eventView.php');
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
    require('./view/eventCreationView.php');
}

function createNewEvent($imageName)
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->createEvent(
        $_POST['title'],
        $_POST['author_id'],
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
        header('Location: ./index_laeti.php?action=showEventCreationPage');
    }
}

function showEventModificationPage($message = null)
{
    // requête SQL pour récuper données et les afficher.
    require('./view/eventModificationView.php');
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
        header('Location: ./index_laeti.php?action=showEvent&id=' . $eventId);
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
        header('Location: ./index_laeti.php?action=showEvent&id=' . $eventId);
    }
}




