<?php

// ALL CONTROLLERS TO WHICH POINTS THE ROUTER

// Version avec classes, avec fonctions

// Chargement des classes
require_once('./model/EventManager.php');

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
    $eventReq = $eventManager->getEvent($_GET['id']);
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

function showEventCreationPage()
{
    require('./view/eventCreationView.php');
}

function createNewEvent()
{
    $eventManager = new EventManager();
    $eventManager->createEvent($_POST['title'], $_POST['author_id'],
        $_POST['description'], $_POST['category_id']);
    /*$eventManager->createEvent($_POST['title'], $_POST['author_id'], $_POST['event_date'],
        $_POST['image'], $_POST['description'], $_POST['category_id']);*/

    listUpcomingEvents();
}




