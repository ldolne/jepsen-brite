<?php

// ALL CONTROLLERS TO WHICH POINTS THE ROUTER

// Version avec classes, avec fonctions

// Chargement des classes
require_once('./model/EventManager.php');

function listEvents()
{
    $eventManager = new EventManager(); // création de l'objet
    $events = $eventManager->getEvents(); // appel d'une fonction de cet objet

    require('./view/homepageView.php');
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



