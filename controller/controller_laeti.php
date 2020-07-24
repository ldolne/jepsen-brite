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

function showEventCreationPage($message = null)
{
    require('./view/eventCreationView.php');
}

function createNewEvent()
{
    $eventManager = new EventManager();
    $affectedLines = $eventManager->createEvent($_POST['title'], $_POST['author_id'],
        $_POST['description'], $_POST['category_id']);
    /*$eventManager->createEvent($_POST['title'], $_POST['author_id'], $_POST['event_date'],
        $_POST['image'], $_POST['description'], $_POST['category_id']);*/

    if ($affectedLines === false) {
        throw new Exception('Problem while creating an event. Please try again.');
    } else {
        $result = '<p>Event has been successfully created.</p>';
        showEventCreationPage($result);
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




